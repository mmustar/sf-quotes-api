<?php


namespace App\Controller;


use App\Entity\QuoteOwner;
use App\Repository\QuoteOwnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\ServerException;
use Doctrine\ORM\ORMException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QuoteOwnerController extends AbstractController
{

    private $logger;
    private $repository;

    public function __construct(LoggerInterface $logger, QuoteOwnerRepository $repository)
    {
        $this->logger = $logger;
        $this->repository = $repository;
    }

    /**
     * @Route("/owners", methods={"GET"})
     */
    public function getAll(): Response
    {
        return $this->json($this->repository->findAll(), Response::HTTP_OK, [], ["groups" => ["owner_api"]] );
    }

    /**
     * @Route("/owners/{id}",requirements={"id"="\d+"}, methods={"GET"})
     */
    public function getOne(int $id): Response
    {
        return $this->json($this->repository->findOneById($id) ?? []);
    }

    /**
     * @Route("/owners/{id}",requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function deleteOne(int $id): Response
    {
        /** @var QuoteOwner $owner */
        $owner = $this->repository->findOneById($id);
        if(!$owner) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }
        $this->repository->delete($owner);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/owners", methods={"POST"})
     */
    public function createOne(Request $request, ValidatorInterface $validator): Response
    {
        $content = json_decode($request->getContent(), true);

        /*if(!$content || !$content->get('fullname')) {
            throw new BadRequestHttpException('No name provided');
        }*/

        $owner = new QuoteOwner($content['fullname'] ?? '');

        $errors = $validator->validate($owner);

        if(count($errors) > 0) {
            return $this->json($errors,Response::HTTP_BAD_REQUEST);
        }

        $this->repository->save($owner);
        return $this->json($owner,Response::HTTP_CREATED);

    }

    /**
     * @Route("/owners/{id}/quotes", methods={"GET"})
     */
    public function getQuotesFromOwner(int $id): Response
    {
        $owner = new QuoteOwner("toto");
        return new JsonResponse($owner->getQuotes());
    }
}
<?php


namespace App\Controller;


use App\Entity\Quote;
use App\Repository\QuoteOwnerRepository;
use App\Repository\QuoteRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QuoteController extends AbstractController
{
    private $logger;
    private $repository;
    private $ownerRepository;

    public function __construct(LoggerInterface $logger, QuoteRepository $repository, QuoteOwnerRepository $ownerRepository)
    {
        $this->logger = $logger;
        $this->repository = $repository;
        $this->ownerRepository = $ownerRepository;
    }

    /**
     * @Route("/quotes", methods={"GET"})
     */
    public function getAll(): Response
    {
        return $this->json($this->repository->findAll(),Response::HTTP_OK, [], ["groups" => ["quote", "owner_api"]] );
    }

    /**
     * @Route("/quotes/{id}",requirements={"id"="\d+"}, methods={"GET"})
     */
    public function getOne(int $id): Response
    {
        return $this->json($this->repository->findOneById($id));
    }

    /**
     * @Route("/quotes", methods={"POST"})
     */
    public function createOne(Request $request, ValidatorInterface $validator): Response
    {
        $content = json_decode($request->getContent(), true);


        $quote = new Quote($content['value'] ?? '');

        $ownerId = $content['owner_id'];
        $owner = $this->ownerRepository->findOneById($ownerId);

        $quote->own($owner);

        $errors = $validator->validate($owner);

        if(count($errors) > 0) {
            return $this->json($errors,Response::HTTP_BAD_REQUEST);
        }

        $this->repository->save($quote);

        return $this->json($quote,Response::HTTP_CREATED, [], ["groups" => ["quote"]] );

    }

}
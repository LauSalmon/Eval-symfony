<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Form\TaskType;
use App\Service\UtilsService;

class TaskController extends AbstractController
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository) 
    {
        $this->taskRepository = $taskRepository;
    }

    #[Route('/task', name: 'app_task')]
    public function addTask(Request $request, EntityManagerInterface $em, TaskRepository $taskRepository): Response
    {
        $msg ="";
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){

            $task->setTitle(UtilsService::cleanInput($task->getTitle()));
            $task->setContent(UtilsService::cleanInput($task->getContent()));
            $task->setExpireDate(new \DateTimeImmutable(UtilsService::cleanInput($form->getData()->getExpireDate()->format('d-m-Y'))));
            //$task->setStatut(UtilsService::cleanInput($task->isStatut()));

            if(!$taskRepository->findOneBy(['title' => $task->getTitle(), 'content' => $task->getContent()])){

                $em->persist($task);
                $em->flush();

                $msg = "La tache a bien été ajoutée en BDD";

            }else {

                $msg = "La tache est déjà enregistré en BDD !";
            }
        }

        return $this->render('task/index.html.twig', [
            'form' => $form->createView(), 
            'msg' => $msg,
        ]);
    }

}

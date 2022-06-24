<?php

namespace App\Controller\API;

use App\Service\MailerService;
use App\Traits\JsonResponseTrait;
use PHPMailer\PHPMailer\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    use JsonResponseTrait;

    /**
     * @throws Exception
     */
    #[Route('/mail/send', name: 'send_mail', methods: ['POST'])]
    public function index(MailerService $mailerService): JsonResponse
    {
        $customerMail = "richardktran.dev@gmail.com";
        $customerName = "Richard K Tran";
        $mailerService->send($customerMail, $customerName);
        return $this->success(['message' => 'Send mail success']);
    }
}

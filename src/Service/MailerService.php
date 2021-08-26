<?php

    namespace App\Service;
    
    use Symfony\Component\Mailer\MailerInterface;
    use Symfony\Component\Mime\Email;
    use Twig\Environment;

class MailerService
{
    /**
     *
     * @var MailerInterface
     */
    private $mailer;

    /**
     * Undocumented variable
     *
     * @var Environnement
     */
    private $twig;



    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function send(array $objetMsg, string $from, string $to, string $template, array $parameters): void
    {
        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject($objetMsg['objetMsg'])
            ->html(
                $this->twig->render($template, $parameters),
                'text/html'
            );

            $this->mailer->send($email);
    }
}
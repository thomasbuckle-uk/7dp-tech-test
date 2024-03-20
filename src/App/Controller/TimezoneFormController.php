<?php

declare(strict_types=1);

namespace App\Controller;

use Domain\Timezone\TimezoneFormRequestDto;
use Domain\Timezone\TimezoneParsingService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TimezoneFormController extends AbstractController
{


    private TimezoneParsingService $timezoneParser;

    public function __construct(
        TimezoneParsingService $timezoneParser
    )
    {
        $this->timezoneParser = $timezoneParser;
    }

    /**
     * @Route("/timezone", name="app_timezone_index")
     * @throws Exception
     */
    public function index(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('date', DateType::class)
            ->add('timezone', TimezoneType::class)
            ->add('submit', SubmitType::class, ['label' => 'Submit'])
            ->getForm();


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $timezoneData = $form->getData();
            $tzRequestDto = new TimezoneFormRequestDto($timezoneData['date'], $timezoneData['timezone']);
            $response = $this->timezoneParser->parse($tzRequestDto);

            return $this->render(
                'timezone/success.html.twig',
                (array)$response
            );
        }

        return $this->renderForm(
            'timezone/index.html.twig',
            ['form' => $form]
        );
    }


}
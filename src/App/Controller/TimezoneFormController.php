<?php

declare(strict_types=1);

namespace App\Controller;

use DateTime;
use DateTimeZone;
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


            $timezone = new DateTimeZone($timezoneData['timezone']);

            $now = new DateTime('now', $timezone);
            $tzOffsetMinutes = $timezone->getOffset($now) / 60;

            $year = date('Y', $timezoneData['date']->getTimestamp());
            $month = date('F', $timezoneData['date']->getTimestamp());
            $febDaysInMonth = cal_days_in_month(CAL_GREGORIAN, 2, $year);
            $userDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $timezoneData['date']->format('m'), $year);

            return $this->render(
                'timezone/success.html.twig',
                [
                    'timezone' => $timezoneData['timezone'],
                    'tzOffsetMinutes' => $tzOffsetMinutes,
                    'febDaysInMonth' => $febDaysInMonth,
                    'month' => $month,
                    'userDaysInMonth' => $userDaysInMonth
                ]
            );
        }

        return $this->renderForm(
            'timezone/index.html.twig',
            ['form' => $form]
        );
    }


}
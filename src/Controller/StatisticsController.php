<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Service\WidgetTotalItems;
use App\Service\WidgetAgeBuildUp;
use App\Service\WidgetJubilee;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class StatisticsController extends AbstractController
{
    /**
     * @Route("/statistics/person", name="statistics_person")
     * @IsGranted("ROLE_STATISTICS_VIEW")
     *
     */
    public function list()
    {
        return $this->render('statistics/statistics.html.twig', []);
    }

    /**
     * @Route("/statistics/club", name="statistics_club")
     * @IsGranted("ROLE_STATISTICS_VIEW")
     *
     */
    public function club()
    {
        return $this->render('statistics/statistics-club.html.twig', []);
    }

    /**
     * @Route("/statistics/jubilee")
     */
    public function Jubilee(Request $request, WidgetJubilee $WidgetJubilee) {

        $data = $WidgetJubilee->WidgetJubilee();

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {

            return new JsonResponse($data);
        }
    }

    /**
     * @Route("/statistics/total-items")
     */
    public function StatsTotalMemebers(Request $request, WidgetTotalItems $WidgetTotalItems) {

        $query = $request->query->get('category');

        $data = $WidgetTotalItems->WidgetTotalItems($query);

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $jsonData = $data;
            return new JsonResponse($jsonData);
        }
    }

    /**
     * @Route("/statistics/relations/age-build-up")
     */
    public function StatsAgeBuildUp(Request $request, WidgetAgeBuildUp $ageBuildUp) {

        $data = $ageBuildUp->WidgetAgeBuildUp();

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $jsonData = $data;
            return new JsonResponse($jsonData);
        }
    }
}

<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Swagger\Annotations as SWG;

use Sentiment\Analyzer;

class AnalysisController
{

    /**
     * Returns a sentinment analysis of a text record.
     *
     * After speach to text to preformed client side, this analyses the text for sentiment traits
     *
     * @Route("/api/analyse", methods={"POST"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns a sentinment analysis summary"
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     type="object",
     *     description="The text to analyze",
     *     @SWG\Schema(
     *         type="object",
    *          @SWG\Property(
    *              type="string",   
    *              property="text",
    *              type="string",
    *              example="This is some text to be analysed"
    *          )
     *     )
     * )
     */
    public function pingAction(Request $request)
    {
        $analyzer = new Analyzer();

        $json = json_decode($request->getContent());

        if ($json == null) {
            return new JsonResponse(array('error' => 'Reqest invalid'), 400);
        }

        return new JsonResponse(array('analysis' => $analyzer->getSentiment($json->text)));
    }
}

<?php

class FireStoreApiClientHelper
{

    private static $apiRoot = 'https://firestore.googleapis.com/v1beta1/';
    private static $project;
    private static $apiKey;

    public static function Initialize($project, $apiKey)
    {
        self::$project = $project;
        self::$apiKey = $apiKey;
    }

    private static function InitializeUrl($method, $params= null)
    {
        $params = is_array($params) ? $params : [];
        return (
            self::apiRoot. 'projects/' . self::project. '/' .
            'databases/(default)/' . $method. '?key=' . self::apiKey. '&' . http_build_query($params)
        );
    }

    private static function OperationGet($method, $params= null)
    {
            $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => self::InitializeUrl($method, $params),
            CURLOPT_USERAGENT => 'cURL'
        ));
            $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    private static function OperationPost($method, $params, $postBody)
    {
            $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => self::InitializeUrl($method, $params),
            CURLOPT_HTTPHEADER => array('Content-Type: application/json', 'Content-Length: '.strlen($postBody)),
            CURLOPT_USERAGENT => 'cURL',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postBody
        ));
            $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    private static function OperationPut($method, $params, $postBody)
    {
            $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_HTTPHEADER => array('Content-Type: application/json', 'Content-Length: '.strlen($postBody)),
            CURLOPT_URL => self::InitializeUrl($method, $params),
            CURLOPT_USERAGENT => 'cURL',
            CURLOPT_POSTFIELDS => $postBody
        ));
            $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    private static function OperationPatch($method, $params, $postBody)
    {
            $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PATCH',
            CURLOPT_HTTPHEADER => array('Content-Type: application/json', 'Content-Length: '.strlen($postBody)),
            CURLOPT_URL => self::InitializeUrl($method, $params),
            CURLOPT_USERAGENT => 'cURL',
            CURLOPT_POSTFIELDS => $postBody
        ));
            $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    private static function OperationDelete($method, $params)
    {
            $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_URL => self::InitializeUrl($method, $params),
            CURLOPT_USERAGENT => 'cURL'
        ));
            $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    private static function GetDocument($collectionName, $documentId= null)
    {
        if ($response = self::OperationGet("documents/$collectionName/$documentId")) {
            return new FireStoreDocument($response);
        }
        throw new Exception("Document doesn't exist");
    }

    /**
    This does not work
     */
    private static function SetDocument($collectionName, $documentId, $document)
    {
        return self::OperationPut(
            "documents/$collectionName/$documentId",

            [ ],
                $document->toJson()
        );
    }

    private static function UpdateDocument($collectionName, $documentId, $document, $documentExists= null)
    {
            $params = [];
        if ($documentExists !== null) {
                $params['currentDocument.exists'] = !!$documentExists;
            }
            return self::OperationPatch(
                "documents/$collectionName/$documentId",
                $params,
                $document->toJson()
            );
    }

    private static function DeleteDocument($collectionName, $documentId)
    {
        return self::OperationDelete(
            "documents/$collectionName/$documentId", []
        );
    }

    private static function AddDocument($collectionName, $document)
    {
        return self::OperationPost(
            "documents/$collectionName",

            [],
                $document->toJson()
        );
    }

}

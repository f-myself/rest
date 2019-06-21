<?php

class DataHandler
{

    private $result;

    function __construct($data, $viewType=VIEW_JSON)
    {
        switch (strtolower($viewType))
        {
            case 'txt':
                $this->result = $this->toText($data);
                break;
            case 'html':
                $this->result = $this->toHtml($data);
                break;
            case 'xml':
                $this->result = $this->toXML($data);
                break;
            default:
                $this->result = $this->toJSON($data);
        }
    }

    private function getResult()
    {
        return $this->result();
    }

    private function toJSON($data)
    {
        return json_encode($data);
    }

    private function toText($data)
    {
        return implode("\n", $data);
    }

    private function toHtml($data)
    {
        if(is_array($data))
        {
            $result = "";
            foreach($data as $value)
            {
                $result .= "<div>";
                if (is_array($value))
                {
                    $result .="<ul>";
                    foreach($value as $param_key => $param_val)
                    {
                        $result .="<li>" . $param_key . ": " . $param_val . "</li>";
                    }
                    $result .="/<ul>";
                }
                if (is_string($data) || is_numeric($data))
                {
                    $result .= "<p>" . $data . "</p>";
                }
                $result .= "</div>"
            }
            return $result;
        }
        return false;
    }

    private function toXML($data)
    {
        $xml = new SimpleXMLElement("<cars/>");

        if(is_array($data))
        {
            foreach ($data as $car)
            {
                array_walk_recursive($car, array($xml, 'addChild'));
            }
            return $xml->asXML();
        }
        return false;
    }

}
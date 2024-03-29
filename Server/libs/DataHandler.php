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

    public function getResult()
    {
        return $this->result;
    }

    private function toJSON($data)
    {
        header('Content-type: application/json');
        if ($data['status'] == 400)
        {
            header("HTTP/1.0 400 Bad Request");
        }
        
        if ($data['status'] == 204)
        {
            header('Status: 204 No Content');
        } else {
            header('Status: 200 Ok');
        }
        return json_encode($data);
        
    }

    private function toText($data)
    {
        header('Content-type: text/plain');
        if ($data['status'] == 400)
        {
            header("HTTP/1.0 400 Bad Request");
        } 
        
        if ($data['status'] == 204)
        {
            header('Status: 204 No Content');
        } else {
            header('Status: 200 Ok');
        }
        $text = "";
        if (is_array($data))
        {
            foreach ($data as $data_key => $data_value)
            {
                if (is_array($data_value))
                {
                    foreach ($data_value as $key => $param)
                    {
                        $text .= "$key: $param\n";
                    }
                }

                if (is_string($data_value))
                {
                    $text .= "$data_key: $data_value\n";
                }
            }
            return $text;
        }
        return false;
    }

    private function toHtml($data)
    {
        header('Content-type: text/html');
        if ($data['status'] == 400)
        {
            header("HTTP/1.0 400 Bad Request");
        }
        
        if ($data['status'] == 204)
        {
            header('Status: 204 No Content');
        } else {
            header('Status: 200 Ok');
        }

        if(is_array($data))
        {
            $result = "";
            foreach($data as $key => $value)
            {
                $result .= "<div>";
                if (is_array($value))
                {
                    $result .="<ul>";
                    foreach($value as $param_key => $param_val)
                    {
                        $result .="<li>" . $param_key . ": " . $param_val . "</li>";
                    }
                    $result .="</ul>";
                }
                if (is_string($value) || is_numeric($value))
                {
                    $result .= "<li>$key: $value</li>";
                }
                $result .= "</div>";
            }
            return $result;
        }
        return false;
    }

    private function toXML($data)
    {
        header('Content-type: application/xml');
        if ($data['status'] == 400)
        {
            header("HTTP/1.0 400 Bad Request");
        }
        
        if ($data['status'] == 204)
        {
            header('Status: 204 No Content');
        } else {
            header('Status: 200 Ok');
        }

        $xml = new SimpleXMLElement('<cars/>');

        if (is_array($data))
        {
            foreach ($data as $data_key => $item)
            {
                if (is_array($item))
                {
                    $car = $xml->addChild('car');
                    foreach ($item as $key => $val)
                    {
                        $car->addChild($key, $val);
                    }
                }

                if(is_string($item))
                {
                    $xml->addChild($data_key, $item);
                }
            }
            $result = $xml->asXML();
            return $result;
        }
        return false;
    }

}
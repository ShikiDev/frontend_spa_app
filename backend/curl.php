<?php

namespace Curl;

//class which work with curl and get data
class CurlWorker{
    public static $link = 'https://www.sknt.ru/job/frontend/data.json';

    /**
     * @return mixed
     */
    public static function getData($by_hardcore = false)
    {
        $result = self::requestData();
        if($by_hardcore) {
            $data = self::parseDataToMyFormat($result);
            $result['data'] = $data;
        }
        return $result;
    }

    /**
     * @return mixed
     */
    private static function requestData()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);

        try {
            if ($result === false) throw new Exception('Error: ' . curl_error($ch));
            $data = json_decode($result);
            if (gettype($data) !== 'object') throw new Exception('Data corrupted');
            if ($data->result !== 'ok') throw new Exception('Data corrupted');
            $response['status'] = 'success';
            $response['data'] = $data->tarifs;
            $response['message'] = 'ok';
        } catch (Exception $e) {
            $response['status'] = 'error';
            $response['data'] = [];
            $response['message'] = "Get error on tring to get data." . $e->getMessage() . "\n";
            return $response;
        }

        return $response;
    }

    private static function parseDataToMyFormat($result = array()){
        $data = array();
        if(empty($result) || (!empty($result) and empty($result['data']))) return $result;

        $tmp = $result['data'];

        foreach($tmp as $key => $t_array){
            $tariff = array();
            $tariff_types = array();
            $tariff['name'] = !empty($t_array->title)? $t_array->title : '';
            $tariff['link'] = !empty($t_array->link)? $t_array->link : '';
            $tariff['speed'] = !empty($t_array->speed)? $t_array->speed : '';
            $tariff['price_add'] = !empty($t_array->speed)? $t_array->speed : '';
            $tariff['free_options'] = !empty($t_array->free_options) ? $t_array->free_options : '';
            if (gettype($tariff['free_options']) == 'string') $tariff['free_options'] = empty($tariff['free_options']) ? $tariff['free_options'] : ' ';
            else $tariff['free_options'] = implode("\n", !empty($tariff['free_options']) ? $tariff['free_options'] : '');
            $tariff['class_name'] = self::setColorByTariffName($tariff['name']);
            $price_array = array();
            $tariff_types['name'] = $tariff['name'];
            foreach($t_array->tarifs as $tariff_elem){
                $tariff_elem->price_one = round(((int)$tariff_elem->price + (int)$tariff_elem->price_add) / (int)$tariff_elem->pay_period) . " р/мес";
                $tariff_elem->new_payday = date('d.m.Y',$tariff_elem->new_payday);
                $tariff_types['types'][$tariff_elem->ID] = $tariff_elem;
                if(empty($tariff_elem->price) or empty($tariff_elem->pay_period)) continue;

                $price_array[] = round(((int)$tariff_elem->price + (int) $tariff_elem->price_add) / (int) $tariff_elem->pay_period);
            }

            $tariff['price_range'] = min($price_array) . ' - ' . max($price_array) . ' р/мес';
            $tariff['id'] = $key + 1;
            $data['tariffs'][] = $tariff;
            asort($tariff_types['types']);
            $data['tariff_types'][$key + 1] =  $tariff_types;
        }

        return $data;
    }

    private static function setColorByTariffName($name){
        $class_name = '';
        switch ($name){
            case 'Земля':
                $class_name = 'speed-earth';
                break;
            case 'Вода':
                $class_name = 'speed-water';
                break;
            case 'Огонь':
                $class_name = 'speed-fire';
                break;
            case 'Огонь HD':
                $class_name = 'speed-fire';
                break;
            case 'Вода HD':
                $class_name = 'speed-water';
                break;
            default:
                $class_name = 'speed-gray';
        }

        return $class_name;
    }
}
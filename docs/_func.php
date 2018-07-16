<?php

function array_map_recursive($func, $arr)
{
    $newArr = array();
    foreach ($arr as $key => $value) {
        $newArr[$key] = (is_array($value) ? array_map_recursive($func, $value) : $func($value));
    }
    return $newArr;
}

function arrayToTable($array, $headerForced = null)
{
    $html = "";
    if (count($array) > 0) {
        if (is_null($headerForced)) {
            $headerRow = array_keys(current($array));
        } else {
            $headerRow = $headerForced; //array
        }

        $html .= '<table class="table table-bordered">
          <thead>
            <tr>
              <th>' . implode('</th><th>', $headerRow) . '</th>
            </tr>
          </thead>
          <tbody>';

        foreach ($array as $row) {
            array_map('htmlentities', $row);
            $html .= '<tr>
                    <td>' . implode('</td><td>', $row) . '</td>
                  </tr>';
        }
        $html .= '</tbody>
        </table>';
    }
    return $html;
}

function array_filter_multi($array, $index, $value, $posYeniden = 0)
{ /* sadece array icin. */
    //pre($array);pre($index);pre($value);
    if (is_object($array) || is_object($array[0])) {
        $array = objectToArray($array);
        $object = 1;
    }
    //pre($array);
    if (is_array($array) && count($array) > 0) {
        $i = $j = 0;

        foreach (array_keys($array) as $key) {
            $sira = $posYeniden == 1 ? $i : $key;
            $temp[$sira] = $array[$key][$index];
            //echo "$temp[$sira] == $value <hr>";
            if (trim($temp[$sira]) == $value) {
                $newarray[$sira] = $array[$key];
                $i++;
            }
            $j++;
        }
    }
    if ($object == 1) {
        return arrayToObject($newarray);
    } else {
        return $newarray;
    }
}

function array_group($array, $field)
{
    $result = array();
    if ($array) {
        foreach ($array as $data) {
            $id = $data[$field];
            if (isset($result[$id])) {
                $result[$id][] = $data;
            } else {
                $result[$id] = array($data);
            }
        }
    }
    return $result;
}

function objectToArray($object)
{
    if (!is_object($object) && !is_array($object)) {
        return $object;
    }
    if (is_object($object)) {
        $object = get_object_vars($object);
        #pre($object);
    }
    if (count($object) == 0) {
        return '';
    } else {
        return array_map('objectToArray', $object);
    }

}
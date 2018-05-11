<?php

namespace InnoBrig\FlexInput;


/**
 * Class Input
 *
 * @package Rgasch\FlexInput
 */
class Input
{
    // These remove all HTML special chars, newlines, etc.
    //public static $defaultFilter = FILTER_SANITIZE_STRING;
    //public static $defaultFlags  = FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH;

    // Encode HTML special chatrs, newlines, etc.
    public static $defaultFilter = FILTER_SANITIZE_STRING;
    public static $defaultFlags  = FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_AMP;


    /**
     * Wrapper for COOKIE input
     *
     * @param string $key     The input field to return.
     * @param mixed  $default The value to return if the requested field is not found (optional) (default=false).
     * @param string $filter  The filter directive to apply to the retrieved input (optional) (default=null)
     * @param array  $args    The filter processing args to apply (optional) (default=array())
     *
     * @return array|mixed
     * @throws \Exception
     */
    public static function fromCookie ($key, $default=null, $filter=null, $args=array())
    {
        if (!$key) {
            return self::filterArray ($_COOKIE, $filter, $args);
        }

        return self::getPassedValue ($key, $default, 'C', $filter, $args);
    }


    /**
     * Wrapper for DELETE input
     *
     * @param string $key     The input field to return.
     * @param mixed  $default The value to return if the requested field is not found (optional) (default=false).
     * @param string $filter  The filter directive to apply to the retrieved input (optional) (default=null)
     * @param array  $args    The filter processing args to apply (optional) (default=array())
     *
     * @return array|mixed
     * @throws \Exception
     */
    public static function fromDelete ($key, $default=null, $filter=null, $args=array())
    {
        if (!$key) {
            $values = array();
            parse_str (file_get_contents("php://input"), $values);
            return self::filterArray ($values, $filter, $args);
        }

        return self::getPassedValue ($key, $default, 'D', $filter, $args);
    }


    /**
     * Wrapper for FILES input
     *
     * @param string $key     The input field to return.
     * @param mixed  $default The value to return if the requested field is not found (optional) (default=false).
     * @param string $filter  The filter directive to apply to the retrieved input (optional) (default=null)
     * @param array  $args    The filter processing args to apply (optional) (default=array())
     *
     * @return array|mixed
     * @throws \Exception
     */
    public static function fromFiles ($key, $default=null, $filter=null, $args=array())
    {
        if (!$key) {
            return self::filterArray ($_FILES, $filter, $args);
        }

        return self::getPassedValue ($key, $default, 'F', $filter, $args);
    }


    /**
     * Wrapper for GET input
     *
     * @param string $key     The input field to return.
     * @param mixed  $default The value to return if the requested field is not found (optional) (default=false).
     * @param string $filter  The filter directive to apply to the retrieved input (optional) (default=null)
     * @param array  $args    The filter processing args to apply (optional) (default=array())
     *
     * @return array|mixed
     * @throws \Exception
     */
    public static function fromGet ($key, $default=null, $filter=null, $args=array())
    {
        if (!$key) {
            return self::filterArray ($_GET, $filter, $args);
        }

        return self::getPassedValue ($key, $default, 'G', $filter, $args);
    }


    /**
     * Wrapper for POST input
     *
     * @param string $key     The input field to return.
     * @param mixed  $default The value to return if the requested field is not found (optional) (default=false).
     * @param string $filter  The filter directive to apply to the retrieved input (optional) (default=null)
     * @param array  $args    The filter processing args to apply (optional) (default=array())
     *
     * @return array|mixed
     * @throws \Exception
     */
    public static function fromPost ($key, $default=null, $filter=null, $args=array())
    {
        if (!$key) {
            return self::filterArray ($_POST, $filter, $args);
        }

        return self::getPassedValue ($key, $default, 'P', $filter, $args);
    }

     /**
      * Wrapper for GET/POST input
      *
      * @param string $key     The input field to return.
      * @param mixed  $default The value to return if the requested field is not found (optional) (default=false).
      * @param string $filter  The filter directive to apply to the retrieved input (optional) (default=null)
      * @param array  $args    The filter processing args to apply (optional) (default=array())
      *
      * @return array|mixed
      * @throws \Exception
      */
     public static function fromGetPost ($key, $default=null, $filter=null, $args=array())
     {
         if (!$key) {
             return self::filterArray ($_GET, $filter, $args);
         }
 
         return self::getPassedValue ($key, $default, 'GP', $filter, $args);
     }



    /**
     * Wrapper for PUT input
     *
     * @param string $key     The input field to return.
     * @param mixed  $default The value to return if the requested field is not found (optional) (default=false).
     * @param string $filter  The filter directive to apply to the retrieved input (optional) (default=null)
     * @param array  $args    The filter processing args to apply (optional) (default=array())
     *
     * @return array|mixed
     * @throws \Exception
     */
    public static function fromPut ($key, $default=null, $filter=null, $args=array())
    {
        if (!$key) {
            $values = array();
            parse_str (file_get_contents("php://input"), $values);
            return self::filterArray ($values, $filter, $args);
        }

        return self::getPassedValue ($key, $default, 'U', $filter, $args);
    }


    /**
     * Wrapper for REQUEST input
     *
     * @param string $key     The input field to return.
     * @param mixed  $default The value to return if the requested field is not found (optional) (default=false).
     * @param string $filter  The filter directive to apply to the retrieved input (optional) (default=null)
     * @param array  $args    The filter processing args to apply (optional) (default=array())
     *
     * @return array|mixed
     * @throws \Exception
     */
    public static function fromRequest ($key, $default=null, $filter=null, $args=array())
    {
        if (!$key) {
            return self::filterArray ($_REQUEST, $filter, $args);
        }

        return self::getPassedValue ($key, $default, 'R', $filter, $args);
    }


    /**
     * Return the requested key using filter_var() from input in a safe way.
     *
     * This function is safe to use for recursive arrays and either returns a non-empty string (or array) or the (optional) default.
     *
     * @param string $key     The input field to return.
     * @param mixed  $default The value to return if the requested field is not found (optional) (default=false).
     * @param string $source  The source field to get a parameter from (optional) (default=null=REQUEST)
     * @param string $filter  The filter directive to apply to the retrieved input (optional) (default=null=FILTER_SANITIZE_STRING)
     * @param array  $args    The filter processing args to apply (optional) (default=array()=FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH)
     * @param bool   $doTrim  Whether or not to apply trim() to retrieved parameter (optional) (default=true)
     *
     * @return mixed The requested input key or the specified default.
     * @throws \Exception
     */
    public static function getPassedValue ($key, $default=null, $source=null, $filter=null, $args=array(), $doTrim=true)
    {
        if (!$key) {
            throw new \Exception ('Empty key passed to Input::getPassedValue()');
        }

        if (!$source) {
            $source = 'REQUEST';
        } else {
            $source = strtoupper ($source);
        }

        if (!$filter) {
            $filter = self::$defaultFilter;
        }

        if (!$args) {
            $args = array ('flags' => self::$defaultFlags);
        }
        $_args = $args;

        $value = $default;
        switch (true) {
            case (isset($_REQUEST[$key]) && !isset($_FILES[$key]) && ($source == 'R' || $source == 'REQUEST')):
                if (is_array($_REQUEST[$key])) {
                    $args['flags'] = FILTER_REQUIRE_ARRAY;
                    $value = self::filterArray ($_REQUEST[$key], $filter, $_args, $doTrim);
                } else {
                    $value = filter_var (self::trim($_REQUEST[$key], $doTrim), $filter, $args);
                }
                break;

            case isset($_GET[$key]) && ($source == 'G' || $source == 'GET'):
                if (is_array($_GET[$key])) {
                    $args['flags'] = FILTER_REQUIRE_ARRAY;
                    $value = self::filterArray ($_GET[$key], $filter, $_args, $doTrim);
                } else {
                    $value = filter_var (self::trim($_GET[$key], $doTrim), $filter, $args);
                }
                break;

            case isset($_POST[$key]) && ($source == 'P' || $source == 'POST'):
                if (is_array($_POST[$key])) {
                    $args['flags'] = FILTER_REQUIRE_ARRAY;
                    $value = self::filterArray ($_POST[$key], $filter, $_args, $doTrim);
                } else {
                    $value = filter_var (self::trim($_POST[$key], $doTrim), $filter, $args);
                }
                break;

            case isset($_COOKIE[$key]) && ($source == 'C' || $source == 'COOKIE'):
                if (is_array($_COOKIE[$key])) {
                    $args['flags'] = FILTER_REQUIRE_ARRAY;
                    $value = self::filterArray ($_COOKIE[$key], $filter, $_args, $doTrim);
                } else {
                    $value = filter_var (self::trim($_COOKIE[$key], $doTrim), $filter, $args);
                }
                break;

            case isset($_FILES[$key]) && ($source == 'F' || $source == 'FILES'):
                if (is_array($_FILES[$key])) {
                    $args['flags'] = FILTER_REQUIRE_ARRAY;
                    $value = self::filterArray ($_FILES[$key], $filter, $_args, $doTrim);
                } else {
                    $value = filter_var (self::trim($_FILES[$key], $doTrim), $filter, $args);
                }
                break;

            case (isset($_GET[$key]) || isset($_POST[$key])) && ($source == 'GP' || $source == 'GETPOST'):
                if (isset($_GET[$key])) {
                    if (is_array($_GET[$key])) {
                        $args['flags'] = FILTER_REQUIRE_ARRAY;
                        $value = self::filterArray ($_GET[$key], $filter, $_args, $doTrim);
                    } else {
                        $value = filter_var (self::trim($_GET[$key], $doTrim), $filter, $args);
                    }
                }
                if (isset($_POST[$key])) {
                    if (is_array($_POST[$key])) {
                        $args['flags'] = FILTER_REQUIRE_ARRAY;
                        $value = self::filterArray ($_POST[$key], $filter, $_args, $doTrim);
                    } else {
                        $value = filter_var (self::trim($_POST[$key], $doTrim), $filter, $args);
                    }
                }
                break;

            case ($source == 'D' || $source == 'DELETE'):
            case ($source == 'U' || $source == 'PUT'):    // P is already taken by POST, so we use U for pUt.
                $values = array();
                parse_str (file_get_contents("php://input"), $values);
                if (is_array($values[$key])) {
                    $args['flags'] = FILTER_REQUIRE_ARRAY;
                    $value = self::filterArray ($values, $filter, $_args, $doTrim);
                } else {
                    $value = filter_var (self::trim($values[$key], $doTrim), $filter, $args);
                }
                break;

            default:
                if ($source) {
                    static $valid = array('R', 'REQUEST', 'G', 'GET', 'P', 'POST', 'GP', 'GETPOST', 'C', 'COOKIE', 'U', 'PUT', 'D', 'DELETE', 'F', 'FILES');
                    if (!in_array($source, $valid)) {
                        throw new \Exception ("Invalid input source [$source] received");
                    }
                }
        }


        return $value;
    }


    /**
     * Filter an array item by item. This function is recursive array safe.
     *
     * @param array  $values  The array to filter
     * @param string $filter  The filter directive to apply to the retrieved input (optional) (default=null)
     * @param array  $args    The filter processing args to apply (optional) (default=array())
     * @param bool   $doTrim  Whether or not to apply trim() to retrieved parameter (optional) (default=true)
     *
     * @return array
     */
    protected static function filterArray (array $values, $filter=null, $args=array(), $doTrim=true)
    {
        if (!$values) {
            return $values;
        }

        if (!$filter) {
            $filter = self::$defaultFilter;
        }

        if (!$args) {
            $args = array ('flags' => self::$defaultFlags);
        }

        foreach ($values as $k=>$v) {
            if (is_array($v)) {
                $values[$k] = self::filterArray ($v, $filter, $args, $doTrim);
            } else {
                $values[$k] = filter_var (self::trim($v, $doTrim), $filter, $args);
            }
        }

        return $values;
    }


    /**
     * Apply trim to an input value as directed by parameters
     *
     * @param string $value   The value as retrieved from input
     * @param bool   $doTrim  Whether or not to apply trim() to the input value
     *
     * @return mixed The supplied input value with trim() applied as specified by the doTrim parameter
     */
    private static function trim ($value, $doTrim)
    {
        if ($doTrim) {
            return trim ($value);
        }

        return $value;
    }


    /**
     * Decode previously encoded HTML entiries
     * WARNING: Only do this if you know you can trust the received input, this is not safe for user-submitted content!
     *
     * @param mixed $data    The field|array|object to decode
     * @param bool  $fields  The array|object fields to decode
     *
     * @return mixed The data with html decoded entities
     */
    public static function decodeEntites ($data, $fields)
    {
        if (!$data) {
            return $data;
        }

        if (!is_array ($fields)) {
            $fields = [$fields];
        }

        if (!is_array ($data)) {
            foreach ($fields as $field) {
                if (is_object($data) && isset($data->{$field})) {
                    $data->{$field} = html_entity_decode ($data->{$field});
                } else {
                    $data[$field] = html_entity_decode ($data[$field]);
                }
            }
        } else {
            foreach ($data as $k => $v) {
                foreach ($fields as $field) {
                    if (is_object($data) && isset($data->{$field})) {
                        $data[$k]->{$field} = html_entity_decode ($v->{$field});
                    } else {
                        $data[$k][$field] = html_entity_decode ($v[$field]);
                    }
                }
            }
        }

        return $data;
    }
}


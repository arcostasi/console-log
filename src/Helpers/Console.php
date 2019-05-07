<?php

namespace Arcostasi\ConsoleLog\Helpers;

use Illuminate\Support\Facades\Session;

class Console
{
    const OUTPUT_EMPTY = '';

    /**
     * Write output to console browser.
     */
    public function Log($data = OUTPUT_EMPTY, $niceFormat = false)
    {
        $configNiceFormat = config('console.nice_format');

        // Check nice format in the configuration
        if ($configNiceFormat) {
            // Set format
            $niceFormat = $configNiceFormat;
        }

        $this->Method($data, $niceFormat ? 'dir' : 'log');
    }

    /**
     * Write output to console browser.
     */
    public function Debug($data = OUTPUT_EMPTY)
    {
        $this->Method($data, 'log');
    }

    /**
     * Write output to console browser in table format.
     */
    public function Table($data = OUTPUT_EMPTY)
    {
        $this->Method($data, 'table');
    }

    /**
     * Write output to console browser in info logging method.
     */
    public function Info($data = OUTPUT_EMPTY)
    {
        $this->Method($data, 'info');
    }

    /**
     * Write output to console browser in warning logging method.
     */
    public function Warn($data = OUTPUT_EMPTY)
    {
        $this->Method($data, 'warn');
    }

    /**
     * Write output to console browser in error logging method.
     */
    public function Error($data = OUTPUT_EMPTY)
    {
        $this->Method($data, 'error');
    }

    /**
     * Write output to console browser in stack trace.
     */
    public function Trace($data = OUTPUT_EMPTY)
    {
        $this->Method($data, 'trace');
    }

    /**
     * Write output to console browser in a nice formatted way.
     */
    public function Dir($data = OUTPUT_EMPTY)
    {
        $this->Method($data, 'dir');
    }

    /**
     * Write output to console browser in a DOM element’s markup.
     */
    public function DirXML($data = OUTPUT_EMPTY)
    {
        $this->Method($data, 'dirxml');
    }

    /**
     * Write output to console browser in an easy way to run simple assertion tests.
     */
    public function Assert($data = OUTPUT_EMPTY)
    {
        $this->Method($data, 'assert');
    }

    /**
     * Clear the console.
     */
    public function Clear()
    {
        Session::forget('console.log');
    }

    /**
     * This method is used to count the number of times it has been invoked
     * with the same provided label.
     */
    public function Count($data = 'even')
    {
        $this->Method($data, 'count');
    }

    /**
     * Start a timer with this method.
     * Optionally the time can have a label.
     */
    public function Time($data = OUTPUT_EMPTY)
    {
        $this->Method($data, 'time');
    }

    /**
     * Finish a timer with this method.
     * Optionally the time can have a label.
     */
    public function TimeEnd($data = OUTPUT_EMPTY)
    {
        $this->Method($data, 'timeEnd');
    }

    /**
     * Use this method to group console messages together with an optional label.
     */
    public function Group($data = OUTPUT_EMPTY)
    {
        $this->Method($data, 'group');
    }

    /**
     * Use this method to end an group of the console messages.
     */
    public function GroupEnd($data = null)
    {
        $this->Method($data, 'groupEnd');
    }

    /**
     * Write output to console browser.
     */
    private function Method($data = OUTPUT_EMPTY, $method = 'log')
    {
        $configOutputEmpty = config('console.output_empty');

        // Check output empty in the configuration
        if (! empty($configOutputEmpty)) {
            // Set format
            $data = $configOutputEmpty;
        }

        // Start buffering
        ob_start();

        if (is_object($data)) { // Check is an object
            $js = "var JSONObject = " . json_encode($data) . ";\n"
                . "var JSONString = JSON.stringify(JSONObject);"
                . "var Object = JSON.parse(JSONString);"
                . "console.$method(Object);";
        } else if (is_array($data)) { // Check is an array
            $js = "var data = " . json_encode($data) . ";\n"
                . "console.$method(data);";
        } else if (! empty($data)) { // Check is not empty
            $js = "var data = decodeURIComponent('" . rawurlencode($data) . "');\n"
                . "console.$method(data);";
        } else {  // Method is empty
            $js = "console.$method();";
        }

        echo $js;

        // Check is not empty
        if (! empty($data)) {
            // Return the contents of the output buffer
            $output = ob_get_contents();

            // Store output in new array with zero index
            Session::push('console.log', $output);
        }

        // Stop buffering
        ob_end_clean();
    }
}
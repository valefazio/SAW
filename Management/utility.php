<?php
    function isFilled($var) {
        $var = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST[$var] : $_GET[$var];
        return isset($var) && $var != "";
    }

    function timerRelocation($var) {
        echo "	<script> setTimeout(function() {
                        window.location.href = '$var';
                    }, 2000);
                </script>";
        exit;
    }

    function alert( $msg, $type = "info") {
        echo "<script> alert('$msg', '$type'); </script>";
    }
?>
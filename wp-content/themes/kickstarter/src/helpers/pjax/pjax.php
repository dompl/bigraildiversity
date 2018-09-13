<?php
/**
 * pJax Helers
 * ---
 */

/* Check is page is loaded with pJax */
function is_pjax() {
    if (isset($_SERVER['HTTP_X_PJAX']) && strtolower($_SERVER['HTTP_X_PJAX']) == 'true') {
        return true;
    }
    return false;
}

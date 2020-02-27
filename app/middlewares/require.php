<?php

/**
 * Requires
 */

return requires($_REQUEST) ?: header('Location: ' . $_SERVER['HTTP_REFERER']);

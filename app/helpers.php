<?php

function alert($msg, $type = 'success')
{
    session()->flash($type, $msg);
}

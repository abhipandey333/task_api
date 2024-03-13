<?php

namespace App;

enum StatusEnum: string
{
    case NEW = "New";
    case INCOMPLETE = "Incomplete";
    case COMPLETE = "Complete";
}

<?php
  
namespace App\Enums;
 
enum DateCycle:string {
	case Annual     = 'annual';
	case Semiannual = 'semiannual';
	case Quarterly  = 'quarterly';
	case Monthly    = 'monthly';
}

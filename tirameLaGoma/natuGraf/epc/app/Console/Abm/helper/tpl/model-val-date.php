      $stamp = strtotime($fields['FNAME']); 
      if (!is_numeric($stamp)){ 
         $this->addError($fields['FNAME'],'FNAME is not a valid date');
         return FALSE; 
      }
      $m = date( 'm', $stamp ); 
      $d = date( 'd', $stamp ); 
      $y = date( 'Y', $stamp ); 

      if (!checkdate($month, $day, $year)){ 
         $this->addError($fields['FNAME'],'FNAME is not a valid date');
      }
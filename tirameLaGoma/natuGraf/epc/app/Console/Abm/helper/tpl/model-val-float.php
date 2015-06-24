    if(filter_var($fields['FNAME'],FILTER_VALIDATE_INT) != $fields['FNAME']){
      $this->addError('FNAME',"FNAME is not a number");
    }
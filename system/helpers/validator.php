<?php

function myValidator($val='', $what='')
{
  // init validitator
  $v = new \Respect\Validation\Validator;

  // validator rules

  // check if it has special signs
  $hasSignValidator = $v::regex('|[`~!@#$%^&*()_\-+=\|\\{[}\]:;"\'<,>.?\/]|');
  // alphanumeric, no white space, min 3, max 50
  $userValidator = $v::alnum()->noWhitespace()->length(3,50);
  // has number, has letters, min 8
  $passValidator = $v::regex('|[0-9]|')->regex('|[a-zA-Z]|')->length(8,null);
  // email address
  $emailValidator = $v::email();
  // iran format, starts with +98, max 13 char
  $irMobileValidator = $v::regex('|^(\+98[0-9]{10})|')->length(null,13);
  // iran format, starts with +98, only numbers
  $irTelValidator = $v::regex('|^(\+98[0-9]{5,12})$|')->length(8,null);
  // should not be empty
  $addressValidator = $v::stringType()->notEmpty()->length(3,100);
  // (cpc: country, province, city) not empty, min max cap
  $cpcValidator = $v::stringType()->notEmpty()->not($v::regex('|\d|'))
   ->not($hasSignValidator)->length(2,30);
  // not empty, no numbers or signs
  $nameValidator = $v::stringType()->notEmpty()->not($v::regex('|\d|'))
    ->not($hasSignValidator)->length(3,50);
  // age. min ~ 0, max ~ 130
  $irBornValidator = $v::intVal()->
    between((intval(date('Y'))-740),(intval(date('Y'))-620));
  // gender, in array
  $genderValidator = $v::in(['male', 'female', 'other']);
  // relation, in array
  $relationValidator = $v::in(['family1', 'family2', 'family3', 'coworker',
    'friend', 'neighbor', 'homemate']);
  $censusValidator = $v::in(['partner', 'father', 'mother', 'sister',
    'brother', 'gfather', 'gmother', 'homemate', 'other']);

  // switch on validator type
  switch ($what)
  {
    case 'sign':
      return $hasSignValidator->validate($val);
      break;
    case 'user':
      return $userValidator->validate($val);
      break;
    case 'pass':
      return $passValidator->validate($val);
      break;
    case 'email':
      return $emailValidator->validate($val);
      break;
    case 'irmobile':
      return $irMobileValidator->validate($val);
      break;
    case 'irtel':
      return $irTelValidator->validate($val);
      break;
    case 'address':
      return $addressValidator->validate($val);
      break;
    case 'cpc':
      return $cpcValidator->validate($val);
      break;
    case 'name':
      return $nameValidator->validate($val);
      break;
    case 'irborn':
      return $irBornValidator->validate($val);
      break;
    case 'gender':
      return $genderValidator->validate($val);
      break;
    case 'relation':
      return $relationValidator->validate($val);
      break;
    default:
      return false;
      break;
  }
}

 ?>

<?php

namespace Models\v1;

class Main
{
  /**
   * local container
   */
  private $cont;

  /**
   * constructor to get the DI container
   */
  function __construct($di)
  {
    $this->cont = $di;
  }

}

 ?>

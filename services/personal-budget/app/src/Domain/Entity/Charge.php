<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\ChargeId;
use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\AMount;
use App\Domain\ValueObject\Date;
use App\Domain\ValueObject\Time;


class Charge {
  private ChargeId $chargeId;
  private BudgetId $budgetId;
  private Title $title;
  private AMount $amount;
  private Date $date;
  private Time $time;

  public function __construct(BudgetId $budgetId,
                                Title $title,AMount $amount, Date $date,Time $time,
                                ChargeId $chargeId = null) {
    $this->budgetId = $budgetId;
    $this->title = $title;
    $this->amount = $amount;
    $this->date = $date;
    $this->time = $time;
    $this->chargeId = $chargeId != null ? $chargeId : new ChargeId($this->generateId());
  }
   
  private function generateId(): string {
    $random = (float)rand() / (float)getrandmax() * 100;
    settype($random, 'integer');
    $date = new \DateTime();
    return $date->getTimestamp() . $random;
  }

  public function getId(): ChargeId {
    return $this->chargeId;
  }

  public function getBudgetId(): BudgetId {
    return $this->budgetId;
  }
  
  public function getTitle(): Title {
    return $this->title;
  }
  
  public function getAMount(): Amount {
    return $this->amount;
  }
  
  public function getDate(): Date {
    return $this->date;
  }
  
  public function getTime(): Time {
    return $this->time;
  }

}
<?php
namespace App\Infraestructure\Database;

use App\Domain\IPersonalBudget;
use App\Domain\Entity\PersonalBudget;
use App\Domain\Entity\Budget;
use App\Domain\Entity\Budgets;
use App\Domain\Entity\OwnerBudgets;
use App\Domain\Entity\Charge;
use App\Domain\Entity\ArrayOfCharges;
use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\OwnerId;
use App\Domain\ValueObject\AMount;
use App\Domain\ValueObject\MountMax;
use App\Domain\ValueObject\MountTotal;
use App\Domain\ValueObject\Type;
use App\Domain\ValueObject\Date;
use App\Domain\ValueObject\Time;
use App\Domain\Entity\ArrayOwnerBudgets;
use App\Domain\ValueObject\ChargeId;
use App\Domain\ValueObject\Title;



class MySqlBudgetRepository extends MySqlRepository implements IPersonalBudget {
  private string $TABLE_NAME = 'personal_budgets';

  public function budgetCreator(PersonalBudget $personalBudget): void {
    $connection = $this->getConnection();
    $sql = 'INSERT INTO '.$this->TABLE_NAME.' (id,owner_id,budget_name,amount,type) VALUES (:id,:owner_id,:budget_name,:amount,:type)';
    $query = $connection->prepare($sql);
    $query->bindParam(':id', $personalBudget->getId()->toString());
    $query->bindParam(':owner_id', $personalBudget->getOwnerId()->toString());
    $query->bindParam(':budget_name', $personalBudget->getName()->toString());
    $query->bindParam(':amount', $personalBudget->getAMount()->toInt());
    $query->bindParam(':type', $personalBudget->getType()->toString());
    $query->execute();
  }

  public function budgetFinderName(BudgetName $budgetName,OwnerId $ownerId): bool {
    $connection = $this->getConnection();
    $sql = 'SELECT * FROM '.$this->TABLE_NAME.' WHERE budget_name = :budget_name AND owner_id = :owner_id';
    $query = $connection->prepare($sql);
    $query->bindParam(':budget_name', $budgetName->toString());
    $query->bindParam(':owner_id', $ownerId->toString());
    $query->execute();    
    $result = $query->fetchAll(\PDO::FETCH_OBJ);
    if(\is_array($result) && sizeof($result) < 1)
      return false;
    else
      return true;
  }
  public function budgetFinderId(BudgetId $budgetId): bool {
    $connection = $this->getConnection();
    $sql = 'SELECT * FROM '.$this->TABLE_NAME.' WHERE id = :id';
    $query = $connection->prepare($sql);
    $query->bindParam(':id', $budgetId->toString());
    $query->execute();    
    $result = $query->fetchAll(\PDO::FETCH_OBJ);
    if(\is_array($result) && sizeof($result) < 1)
      return false;
    else
      return true;
  }

  public function validateOwner(OwnerId $ownerId): bool {
    $connection = $this->getConnection();
    $sql = 'SELECT * FROM '.$this->TABLE_NAME.' WHERE owner_id = :id';
    $query = $connection->prepare($sql);
    $query->bindParam(':id', $ownerId->toString());
    $query->execute();    
    $result = $query->fetchAll(\PDO::FETCH_OBJ);
    if(\is_array($result) && sizeof($result) < 1)
      return false;
    else
      return true;
  }


  public function budgetUpdater(Budget $budget): bool {
    $connection = $this->getConnection();
    $sql = 'UPDATE '.$this->TABLE_NAME.' SET budget_name = :budget_name , type = :type, amount = :amount WHERE id = :budget_id';
    $query = $connection->prepare($sql);
    $query->bindParam(':budget_name', $budget->getName()->toString());
    $query->bindParam(':amount',$budget->getAMount()->toInt());
    $query->bindParam(':type', $budget->getType()->toString());
    $query->bindParam(':budget_id',$budget->getId()->toString());
    $query->execute();    
    return true;
  }


  public function budgetDeleter(BudgetId $budgetId): bool {
    $connection = $this->getConnection();
    $sql = 'DELETE FROM '.$this->TABLE_NAME.' WHERE id = :id ';
    $query = $connection->prepare($sql);
    $query->bindParam(':id',$budgetId->toString());
    $query->execute();    

    $sql = 'DELETE FROM personalcharges WHERE budget_id = :budget_id';
    $query2 = $connection->prepare($sql);
    $query2->bindParam(':budget_id',$budgetId->toString());
    $query2->execute();

    if($query->rowCount()>0)
      return true;
    else
      return false;
  }

  public function budgetIdFinder(OwnerId $ownerId): ArrayOwnerBudgets {
    $budgets = new ArrayOwnerBudgets;
    $connection = $this->getConnection();
    $sql = 'SELECT id, budget_name FROM '.$this->TABLE_NAME.' WHERE owner_id = :owner_id';
    $query = $connection->prepare($sql);
    $query->bindParam(':owner_id', $ownerId->toString());
    $query->execute();    
    $result = $query->fetchAll(\PDO::FETCH_OBJ);
    if($result == null)
      return $budgets;

    foreach($result as $budget) {      
      $budgets->addBudget(new OwnerBudgets(
                          new BudgetId($budget->id),
                          new BudgetName($budget->budget_name))
       );
    }   
      return $budgets; 
    }


    public function chargeExists(BudgetId $budgetId,Title $title):bool{
      $connection = $this->getConnection();
      $sql = 'SELECT * FROM personalcharges  WHERE budget_id = :budget_id AND title = :title';
      $query = $connection->prepare($sql);
      $query->bindParam(':budget_id', $budget_id->toString()); 
      $query->bindParam(':title', $title->toString()); 
      $query->execute();
      $result = $query->fetchAll(\PDO::FETCH_OBJ);
      if(\is_array($result) && sizeof($result) < 1)
        return false;
      else
        return true;
    }

    public function budgetItemCreator(Charge $charge):void{
      $connection = $this->getConnection();
      $sql = 'INSERT INTO personalcharges (charge_id,budget_id,title,date,time,amount) VALUES (:charge_id,:budget_id,:title,:date,:time,:amount)';
      $query = $connection->prepare($sql);
      $query->bindParam(':charge_id', $charge->getId()->toString());
      $query->bindParam(':budget_id', $charge->getBudgetId()->toString());
      $query->bindParam(':title', $charge->getTitle()->toString());
      $query->bindParam(':date', $charge->getDate()->toString());
      $query->bindParam(':time', $charge->getTime()->toString());
      $query->bindParam(':amount', $charge->getAMount()->toInt());
      $query->execute();
    }


    public function chargeFinderId(ChargeId $chargeId): bool{
      $connection = $this->getConnection();
      $sql = 'SELECT * FROM personalcharges WHERE charge_id = :charge_id';
      $query = $connection->prepare($sql);
      $query->bindParam(':charge_id', $chargeId->toString());
      $query->execute();    
      $result = $query->fetchAll(\PDO::FETCH_OBJ);
      if(\is_array($result) && sizeof($result) < 1)
        return false;
      else
        return true;
    }

    public function budgetItemDeleter(ChargeId $chargeId): bool{
      $connection = $this->getConnection();
      $sql = 'DELETE FROM personalcharges WHERE charge_id = :charge_id';
      $query = $connection->prepare($sql);
      $query->bindParam(':charge_id',$chargeId->toString());
      $query->execute();    
      if($query->rowCount()>0)
        return true;
      else
        return false;
    }

    public function budgetFinder(BudgetId $budgetId): PersonalBudget {
      $connection = $this->getConnection();
      $sql = 'SELECT * FROM '.$this->TABLE_NAME.' WHERE budget_id = :budget_id';
      $query = $connection->prepare($sql);
      $query->bindParam(':budget_id', $budgetId->toString());
      $query->execute();    
      $result = $query->fetchAll(\PDO::FETCH_OBJ);
     
      if(\is_array($result) && sizeof($result) < 1)
        return null;
      else
        return new PersonalBuget(new Type($result->type),
                                  new AMount($result->amount),
                                  new BudgetName($result->budget_name),
                                  new OwnerId($result->owner_id),
                                  new BudgetId($budgetId));
      }

    public function getBudgets(BudgetId $budgetId):Budgets{
      $connection = $this->getConnection();
      $sql = 'SELECT * FROM '.$this->TABLE_NAME.' WHERE id = :budget_id';
      $query = $connection->prepare($sql);
      $query->bindParam(':budget_id', $budgetId->toString());
      $query->execute();    
      $result = $query->fetchAll(\PDO::FETCH_OBJ);
      if(\is_array($result) && sizeof($result) < 1)
        throw new \Exception('The budget does not exist '.$budgetId);
      else
        $result = $result[0];
        return new Budgets( $budgetId,
                            new BudgetName($result->budget_name),
                            new OwnerId($result->owner_id),
                            new AMount($result->amount),
                            new Type($result->type));
    }

    public function getCharges(BudgetId $budgetId):ArrayOfCharges {
      $budgets = new ArrayOfCharges(); 
      $connection = $this->getConnection();
      $sql = 'SELECT * FROM personalcharges WHERE budget_id = :budget_id';
      $query = $connection->prepare($sql);
      $query->bindParam(':budget_id', $budgetId->toString()); 
      $query->execute();
      $result = $query->fetchAll(\PDO::FETCH_OBJ);  
      if ($result == null)
        return $budgets;

      foreach($result as $budget) {      
        $budgets->addBudget(new Charge(
                                  new BudgetId($budget->budget_id),
                                  new Title($budget->title),
                                  new AMount($budget->amount),
                                  new Date($budget->date),
                                  new Time($budget->time),
                                  new ChargeId($budget->charge_id),
                                )
                           );
      }    
      return $budgets;
    }

    public function getChargesTotal(BudgetId $budgetId): Int {
      $connection = $this->getConnection();
      $sql = 'SELECT SUM(amount) AS total FROM  personalcharges  WHERE budget_id = :budget_id';
      $query = $connection->prepare($sql);
      $query->bindParam(':budget_id', $budgetId->toString());
      $query->execute();
      $result = $query->fetchAll(\PDO::FETCH_OBJ);
      $result = $result[0];
      if($result->total==null){
        return 0;
      }else{
        return $result->total;
      }
    }


    public function getBudgetMax(BudgetId $budgetId): Int {
      $connection = $this->getConnection();
      $sql = 'SELECT type, amount FROM '.$this->TABLE_NAME.' WHERE id = :budget_id';
      $query = $connection->prepare($sql);
      $query->bindParam(':budget_id', $budgetId->toString());
      $query->execute();
      $result = $query->fetchAll(\PDO::FETCH_OBJ);
      $result=$result[0];
      if($result->type=='MONTHLY'){
        return ($result->amount);
      }else{
        return ($result->amount)/12;
      }
    }

}

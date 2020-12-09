<?php
namespace App\Infraestructure\Database;

use App\Domain\IBudgetRepository;
use App\Domain\Entity\CompanyBudget;
use App\Domain\Entity\Budget;
use App\Domain\Entity\Budgets;
use App\Domain\Entity\Collaborator;
use App\Domain\Entity\BudgetQuantities;
use App\Domain\Entity\ArrayOwnerBudgets;
use App\Domain\Entity\ArrayCollaborators;
use App\Domain\Entity\ArrayCharges;
use App\Domain\Entity\OwnerBudgets;
use App\Domain\Entity\Charge;
use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\CollaboratorId;
use App\Domain\ValueObject\ChargeId;
use App\Domain\ValueObject\CollaboratorName;
use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\OwnerId;
use App\Domain\ValueObject\BudgetLimit;
use App\Domain\ValueObject\BudgetPercentage;
use App\Domain\ValueObject\BudgetQuantity;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Date;
use App\Domain\ValueObject\Time;

class MySqlBudgetRepository extends MySqlRepository implements IBudgetRepository {
  private string $TABLE_NAME = 'company_budgets';

  public function budgetCreator(CompanyBudget $companyBudget): void {
    $connection = $this->getConnection();
    $sql = 'INSERT INTO '.$this->TABLE_NAME.' (id,owner_id,budget_name,budget_limit) VALUES (:id,:owner_id,:budget_name,:budget_limit)';
    $query = $connection->prepare($sql);
    $query->bindParam(':id', $companyBudget->getId()->toString());
    $query->bindParam(':owner_id', $companyBudget->getOwnerId()->toString());
    $query->bindParam(':budget_name', $companyBudget->getName()->toString());
    $query->bindParam(':budget_limit', $companyBudget->getBudgetLimit()->toInt());
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

  public function searchBudgetCollaborator(BudgetId $budgetId,CollaboratorId $collaboratorId): bool {
    $connection = $this->getConnection();
    $sql = 'SELECT * FROM collaborators WHERE collaborator_id = :collaborator_id AND budget_id = :budget_id';
    $query = $connection->prepare($sql);
    $query->bindParam(':collaborator_id', $collaboratorId->toString());
    $query->bindParam(':budget_id', $budgetId->toString());
    $query->execute();    
    $result = $query->fetchAll(\PDO::FETCH_OBJ);
    if(\is_array($result) && count($result) < 1)
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

  public function validateCollaborator(CollaboratorId $collaboratorId): bool {
    $connection = $this->getConnection();
    $sql = 'SELECT * FROM collaborators WHERE collaborator_id = :id';
    $query = $connection->prepare($sql);
    $query->bindParam(':id', $collaboratorId->toString());
    $query->execute();    
    $result = $query->fetchAll(\PDO::FETCH_OBJ);
    if(\is_array($result) && sizeof($result) < 1)
      return false;
    else
      return true;
  }
  
  public function getBudgetQuantities(BudgetId $budgetId): BudgetQuantities {
    $connection = $this->getConnection();
    $sql = 'SELECT budget_limit,budget_percentage FROM '.$this->TABLE_NAME.' WHERE id = :budget_id';
    $query = $connection->prepare($sql);
    $query->bindParam(':budget_id', $budgetId->toString());
    $query->execute();    
    $result = $query->fetchAll(\PDO::FETCH_OBJ);
    $percentage = $result[0];
    if(\is_array($result) && sizeof($result) < 1)
      return 0;
    else
      $budgetQuantities = new BudgetQuantities(new BudgetPercentage(\intval($percentage->budget_percentage))
                                                ,new BudgetLimit(\intval($percentage->budget_limit)));
      return $budgetQuantities;
  }
  
  public function searchQuantitiesCollaborator(BudgetId $budgetId,CollaboratorId $collaboratorId): BudgetQuantities {
    $connection = $this->getConnection();
    $sql = 'SELECT budget_percentage FROM collaborators WHERE collaborator_id = :collaborator_id AND budget_id = :budget_id';
    $query = $connection->prepare($sql);
    $query->bindParam(':collaborator_id', $collaboratorId->toString());
    $query->bindParam(':budget_id', $budgetId->toString());
    $query->execute();   
    $result = $query->fetchAll(\PDO::FETCH_OBJ);
    $quantities = $result[0];
    return new BudgetQuantities(new BudgetPercentage($quantities->budget_percentage),new BudgetLimit($quantities->budget_percentage));
  }

  public function budgetUpdater(Budget $budget): bool {
    $connection = $this->getConnection();
    $sql = 'UPDATE '.$this->TABLE_NAME.' SET budget_name = :budget_name , budget_limit = :budget_limit WHERE id = :budget_id';
    $query = $connection->prepare($sql);
    $query->bindParam(':budget_name', $budget->getName()->toString());
    $query->bindParam(':budget_limit',$budget->getBudgetLimit()->toInt());
    $query->bindParam(':budget_id',$budget->getId()->toString());
    $query->execute();    
    return true;
  }

  public function updatedBudgetQuantities(BudgetId $budgetid,Int $budgetPercentage): bool {
    $connection = $this->getConnection();
    $sql = 'UPDATE '.$this->TABLE_NAME.' SET budget_percentage = :budget_percentage WHERE id = :budget_id';
    $query = $connection->prepare($sql);
    $query->bindParam(':budget_percentage',$budgetPercentage);
    $query->bindParam(':budget_id',$budgetid->toString());
    $query->execute();    
    if($query->rowCount()>0)
      return true;
    else
      return false;
  }

  public function budgetCollaboratorUpdated(Collaborator $collaborator): bool {
    $connection = $this->getConnection();
    $sql = 'UPDATE collaborators SET budget_percentage = :budget_percentage 
            WHERE budget_id = :budget_id AND collaborator_id = :collaborator_id';
    $query = $connection->prepare($sql);
    $query->bindParam(':budget_percentage',$collaborator->getBudgetPercentage()->toInt());
    $query->bindParam(':budget_id',$collaborator->getId()->toString());
    $query->bindParam(':collaborator_id',$collaborator->getIdCollaborator()->toString());
    $query->execute();    
    if($query->rowCount()>0)
      return true;
    else
      return false;
  }

  public function budgetDeleter(BudgetId $budgetId): bool {
    $connection = $this->getConnection();
    $sql = 'DELETE FROM company_budgets WHERE id = :budget_id';
    $query = $connection->prepare($sql);
    $query->bindParam(':budget_id',$budgetId->toString());
    $query->execute();    
    
    $sql = 'DELETE FROM collaborators WHERE budget_id = :budget_id';
    $query2 = $connection->prepare($sql);
    $query2->bindParam(':budget_id',$budgetId->toString());
    $query2->execute();

    $sql = 'DELETE FROM charges WHERE budget_id = :budget_id';
    $query3 = $connection->prepare($sql);
    $query3->bindParam(':budget_id',$budgetId->toString());
    $query3->execute();

    if($query->rowCount()>0)
      return true;
    else
      return false;
  }

  public function budgetFinder(BudgetId $budgetId): CompanyBudget {
    $connection = $this->getConnection();
    $sql = 'SELECT * FROM '.$this->TABLE_NAME.' WHERE budget_id = :budget_id';
    $query = $connection->prepare($sql);
    $query->bindParam(':budget_id', $budgetId->toString());
    $query->execute();    
    $result = $query->fetchAll(\PDO::FETCH_OBJ);
   
    if(\is_array($result) && sizeof($result) < 1)
      return null;
    else
      return new CompanyBuget(new BudgetName($result->budget_name),
                                new OwnerId($result->owner_id),new BudgetLimit($result->budget_limit),
                                new BudgetId($budgetId));
    }

    public function budgetCollaboratorAdder(Collaborator $collaborator): void {
      $connection = $this->getConnection();
      $sql = 'INSERT INTO collaborators (collaborator_id,budget_id,collaborator_name,budget_percentage) VALUES (:collaborator_id,:budget_id,:collaborator_name,:budget_percentage)';
      $query = $connection->prepare($sql);
      $query->bindParam(':collaborator_id', $collaborator->getIdCollaborator()->toString());
      $query->bindParam(':budget_id', $collaborator->getId()->toString());
      $query->bindParam(':collaborator_name', $collaborator->getName()->toString());
      $query->bindParam(':budget_percentage', $collaborator->getBudgetPercentage()->toInt());
      $query->execute();
    }

    public function budgetCollaboratorRemover(BudgetId $budgetId,CollaboratorId $collaboratorId): bool {
      $connection = $this->getConnection();
      $sql = 'DELETE FROM collaborators  WHERE collaborator_id = :collaborator_id AND budget_id = :budget_id';
      $query = $connection->prepare($sql);
      $query->bindParam(':collaborator_id', $collaboratorId->toString());
      $query->bindParam(':budget_id', $budgetId->toString());
      $query->execute();

      $sql = 'DELETE FROM charges  WHERE collaborator_id = :collaborator_id AND budget_id = :budget_id';
      $query2 = $connection->prepare($sql);
      $query2->bindParam(':collaborator_id', $collaboratorId->toString());
      $query2->bindParam(':budget_id', $budgetId->toString());
      $query2->execute();
      return true;
    }

    public function searchCollaborator(BudgetId $budgetId,CollaboratorId $collaboratorId): bool {
      $connection = $this->getConnection();
      $sql = 'SELECT * FROM  collaborators  WHERE collaborator_id = :collaborator_id AND budget_id = :budget_id';
      $query = $connection->prepare($sql);
      $query->bindParam(':collaborator_id', $collaboratorId->toString());
      $query->bindParam(':budget_id', $budgetId->toString());
      $query->execute();
      $result = $query->fetchAll(\PDO::FETCH_OBJ);
      if(\is_array($result) && count($result) < 1)
        $flag = false;
      else
        $flag = true;
      return $flag;
    }
    
    public function getCollaborator(BudgetId $budgetId,CollaboratorId $collaboratorId): Collaborator {
      $connection = $this->getConnection();
      $sql = 'SELECT * FROM  collaborators  WHERE collaborator_id = :collaborator_id AND budget_id = :budget_id';
      $query = $connection->prepare($sql);
      $query->bindParam(':collaborator_id', $collaboratorId->toString());
      $query->bindParam(':budget_id', $budgetId->toString());
      $query->execute();
      $result = $query->fetchAll(\PDO::FETCH_OBJ);
      $collaborator = $result[0];
      return new Collaborator(new CollaboratorId($collaborator->collaborator_id),
                              new BudgetId($collaborator->budget_id),
                              new CollaboratorName($collaborator->collaborator_name),
                              new BudgetPercentage($collaborator->budget_percentage)
                            );
    }

    public function getChargesCollaborator(BudgetId $budgetId,CollaboratorId $collaboratorId): Int {
      $connection = $this->getConnection();
      $sql = 'SELECT SUM(amount) AS total FROM  charges  WHERE collaborator_id = :collaborator_id AND budget_id = :budget_id';
      $query = $connection->prepare($sql);
      $query->bindParam(':collaborator_id', $collaboratorId->toString());
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

    public function budgetIdFinder(OwnerId $ownerId): ArrayOwnerBudgets {
      $budgets = new ArrayOwnerBudgets(); 
      $connection = $this->getConnection();
      $sql = 'SELECT id,budget_name FROM company_budgets WHERE owner_id = :owner_id';
      $query = $connection->prepare($sql);
      $query->bindParam(':owner_id', $ownerId->toString()); 
      $query->execute();
      $result = $query->fetchAll(\PDO::FETCH_OBJ);  
      if ($result == null)
        return $budgets;

      foreach($result as $budget) {      
        $budgets->addBudget(new OwnerBudgets(
                              new BudgetId($budget->id),
                              new BudgetName($budget->budget_name))
        );
      }    
      return $budgets;
    }

    public function collaboratorIdFinder(CollaboratorId $collaboratorId): ArrayOwnerBudgets {
      $budgets = new ArrayOwnerBudgets(); 
      $connection = $this->getConnection();
      $sql = 'SELECT b.id,b.budget_name FROM company_budgets AS b INNER JOIN collaborators AS c ON b.id = c.budget_id WHERE collaborator_id = :collaborator_id';
      $query = $connection->prepare($sql);
      $query->bindParam(':collaborator_id', $collaboratorId->toString()); 
      $query->execute();
      $result = $query->fetchAll(\PDO::FETCH_OBJ);  
      if ($result == null)
        return $budgets;

      foreach($result as $budget) {      
        $budgets->addBudget(new OwnerBudgets(
                              new BudgetId($budget->id),
                              new BudgetName($budget->budget_name))
        );
      }    
      return $budgets;
    }

    public function chargeExists(CollaboratorId $CollaboratorId,BudgetId $budgetId,Title $title):bool{
      $connection = $this->getConnection();
      $sql = 'SELECT * FROM charges  WHERE collaborator_id = :collaborator_id AND budget_id = :budget_id AND title = :title';
      $query = $connection->prepare($sql);
      $query->bindParam(':collaborator_id', $collaboratorId->toString()); 
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
      $sql = 'INSERT INTO charges (charge_id,collaborator_id,budget_id,title,date,time,amount) VALUES (:charge_id,:collaborator_id,:budget_id,:title,:date,:time,:amount)';
      $query = $connection->prepare($sql);
      $query->bindParam(':charge_id', $charge->getId()->toString());
      $query->bindParam(':collaborator_id', $charge->getCollaboratorId()->toString());
      $query->bindParam(':budget_id', $charge->getBudgetId()->toString());
      $query->bindParam(':title', $charge->getTitle()->toString());
      $query->bindParam(':date', $charge->getDate()->toString());
      $query->bindParam(':time', $charge->getTime()->toString());
      $query->bindParam(':amount', $charge->getBudgetLimit()->toInt());
      $query->execute();
    }

    public function getCollaborators(BudgetId $budgetId):ArrayCollaborators {
      $connection = $this->getConnection();
      $sql = 'SELECT * FROM collaborators WHERE budget_id = :budget_id';
      $query = $connection->prepare($sql);
      $query->bindParam(':budget_id', $budgetId->toString()); 
      $query->execute();
      $result = $query->fetchAll(\PDO::FETCH_OBJ);  
      $budgets = new ArrayCollaborators();
      if ($result == null)
        return $budgets;
      foreach($result as $budget) {      
        $budgets->addBudget(new Collaborator(
                                  new CollaboratorId($budget->collaborator_id),
                                  new BudgetId($budget->budget_id),
                                  new CollaboratorName($budget->collaborator_name),
                                  new BudgetPercentage($budget->budget_percentage)
                                )
                           );
      }    
      return $budgets;
    }
    
    public function getCharges(BudgetId $budgetId):ArrayCharges {
      $budgets = new ArrayCharges(); 
      $connection = $this->getConnection();
      $sql = 'SELECT * FROM charges WHERE budget_id = :budget_id';
      $query = $connection->prepare($sql);
      $query->bindParam(':budget_id', $budgetId->toString()); 
      $query->execute();
      $result = $query->fetchAll(\PDO::FETCH_OBJ);  
      if ($result == null)
        return $budgets;

      foreach($result as $budget) {      
        $budgets->addBudget(new Charge(
                                  new CollaboratorId($budget->collaborator_id),
                                  new BudgetId($budget->budget_id),
                                  new Title($budget->title),
                                  new BudgetLimit($budget->amount),
                                  new Date($budget->date),
                                  new Time($budget->time),
                                  new ChargeId($budget->charge_id),
                                )
                           );
      }    
      return $budgets;
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
                            new BudgetLimit($result->budget_limit),
                            new BudgetPercentage($result->budget_percentage));
    }

    public function chargeFinderId(ChargeId $chargeId): bool{
      $connection = $this->getConnection();
      $sql = 'SELECT * FROM charges WHERE charge_id = :id';
      $query = $connection->prepare($sql);
      $query->bindParam(':id', $chargeId->toString());
      $query->execute();    
      $result = $query->fetchAll(\PDO::FETCH_OBJ);
      if(\is_array($result) && sizeof($result) < 1)
        return false;
      else
        return true;
    }

    public function budgetItemRemover(ChargeId $chargeId): bool{
      $connection = $this->getConnection();
      $sql = 'DELETE FROM charges WHERE charge_id = :budget_id';
      $query = $connection->prepare($sql);
      $query->bindParam(':budget_id',$chargeId->toString());
      $query->execute();    
      if($query->rowCount()>0)
        return true;
      else
        return false;
    }
  // public function get(UserId $id): ?User {
  //   $connection = $this->getConnection();
  //   $sql = 'SELECT * FROM '.$this->TABLE_NAME.' WHERE id = :id';
  //   $query = $connection->prepare($sql);
  //   $query->bindParam(':id', $id->toString());
  //   $query->execute();
  //   $user = $query -> fetchAll(\PDO::FETCH_OBJ);

  //   if($user == null)
  //     return null;
    
  //   $user = $user[0];
  //   $user_name = explode(" ", $user->client_name);

  //   return new User(
  //     new UserName($user_name[0], $user_name[1]),
  //     new UserId($user->id)
  //   );
  // }

  // public function update(User $user): bool {
  //   return false;
  // }

  // public function delete(UserId $id): bool {
  //   return false;
  // }

}

//     const userName = users[0].client_name.split(' ')
//     return new User(
//       new UserName(userName[0], userName[1]),
//       new UserId(users[0].id)
//     )
//   }

//   public async update(user: User): Promise<boolean> {
//     const connection = await this.getConnection()
//     const sql = `UPDATE ${this.TABLE_NAME} SET client_name = ? WHERE id = ?`

//     const response = await connection
//       .query(sql, [user.getName().toString(), user.getId().toString()])
//       .catch((err) => Promise.reject(err))

//     const userUpdated = response.affectedRows !== 0
//     return userUpdated
//   }

//   public async delete(id: UserId): Promise<boolean> {
//     const connection = await this.getConnection()
//     const sql = `DELETE FROM ${this.TABLE_NAME} WHERE id = ?`

//     const response = await connection
//       .query(sql, [id.toString()])
//       .catch((err) => Promise.reject(err))

//     const userDeleted = response.affectedRows !== 0
//     return userDeleted
//   }
// }

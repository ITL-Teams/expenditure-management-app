<?php
namespace App\Infraestructure\Database;

use App\Domain\IUserRepository;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\UserName;

class MySqlUserRepository extends MySqlRepository implements IUserRepository {
  private string $TABLE_NAME = 'client';

  public function create(User $user): void {
    $connection = $this->getConnection();
    $sql = 'INSERT INTO '.$this->TABLE_NAME.' (id,client_name) VALUES (:id,:client_name)';
    $query = $connection->prepare($sql);
    $query->bindParam(':id', $user->getId()->toString());
    $query->bindParam(':client_name', $user->getName()->toString());
    $query->execute();    
  }

  public function get(UserId $id): ?User {
    return null;
  }

  public function update(User $user): bool {
    return false;
  }

  public function delete(UserId $id): bool {
    return false;
  }

  // public function get(UserId $id): ?User {
  //   $connection = $this->getConnection();
  //   $sql = 'SELECT * FROM '.$this->TABLE_NAME.' WHERE id = :id';
  //   $query = $connection->prepare($sql);
  //   $query->bindParam(':id', $id->toString());
  //   $query->execute();
  //   $user = $query -> fetchAll(PDO::FETCH_OBJ);

  //   if(!is_array($user) || sizeof($users) == 0)
  //     return null;
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

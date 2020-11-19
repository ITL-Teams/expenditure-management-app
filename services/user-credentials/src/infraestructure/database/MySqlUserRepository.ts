import { MySqlRepository } from './MySqlRepository'
import { ICredentialsRepository } from '../../domain/ICredentialsRepository'
import { LoginUser } from '../../domain/entity/LoginUser'
import { RegisterUser } from '../../domain/entity/RegisterUser'
import { Email } from '../../domain/value-object/Email'
import { Password } from '../../domain/value-object/Password'
import { UserAlreadyExists } from './error/UserAlreadyExists'
import { UserId } from '../../domain/value-object/UserId'
import { EnterpriseAccount } from '../../domain/value-object/EnterpriseAccount'
import { TwoFactorAuth } from '../../domain/value-object/TwoFactorAuth'

export class MySqlUserRepository
  extends MySqlRepository
  implements ICredentialsRepository {
  private readonly TABLE_NAME = 'user_credentials'

  public async create(user: RegisterUser): Promise<void> {
    const connection = await this.getConnection()
    const sql = `INSERT INTO ${this.TABLE_NAME} 
    (id,email,firstName,lastName,user_password,user_signature,isEnterpriseAccount,hasTwoFactorAuth)
    VALUES (?,?,?,?,?,?,?,?)`

    return connection
      .query(sql, [
        user.getId().toString(),
        user.getEmail().toString(),
        user.getFirstName().toString(),
        user.getLastName().toString(),
        user.getPassword().toString(),
        user.getSignature().toString(),
        user.isEnterpriseAccount().getValue() ? '' : null,
        null
      ])
      .catch((err) => {
        throw new UserAlreadyExists(user.getEmail().toString())
      })
  }

  public async find(email: Email): Promise<LoginUser> {
    const connection = await this.getConnection()
    const sql = `SELECT * FROM ${this.TABLE_NAME} WHERE email = ?`

    let user = await connection.query(sql, [email.toString()]).catch((err) => {
      throw new Error(err)
    })

    if (!Array.isArray(user) || user.length === 0) return null

    user = user[0]

    return new LoginUser(
      new UserId(user.id),
      new Password(user.user_password, false),
      new EnterpriseAccount(user.isEnterpriseAccount !== null),
      new TwoFactorAuth(user.hasTwoFactorAuth !== null)
    )
  }
}

//   const userName = users[0].client_name.split(' ')
//   return new User(
//     new UserName(userName[0], userName[1]),
//     new UserId(users[0].id)
//   )
// }

// public async update(user: User): Promise<boolean> {
//   const connection = await this.getConnection()
//   const sql = `UPDATE ${this.TABLE_NAME} SET client_name = ? WHERE id = ?`

//   const response = await connection
//     .query(sql, [user.getName().toString(), user.getId().toString()])
//     .catch((err) => Promise.reject(err))

//   const userUpdated = response.affectedRows !== 0
//   return userUpdated
// }

// public async delete(id: UserId): Promise<boolean> {
//   const connection = await this.getConnection()
//   const sql = `DELETE FROM ${this.TABLE_NAME} WHERE id = ?`

//   const response = await connection
//     .query(sql, [id.toString()])
//     .catch((err) => Promise.reject(err))

//   const userDeleted = response.affectedRows !== 0
//   return userDeleted
// }

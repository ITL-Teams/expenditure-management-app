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
import { TwoFactor } from '../../domain/entity/TwoFactor'
import { TwoFactorKey } from '../../domain/value-object/TwoFactorKey'
import { AccountVerified } from '../../domain/value-object/AccountVerified'

export class MySqlUserRepository
  extends MySqlRepository
  implements ICredentialsRepository {
  private readonly TABLE_NAME = 'user_credentials'

  public async create(user: RegisterUser): Promise<void> {
    const connection = await this.getConnection()
    const sql = `INSERT INTO ${this.TABLE_NAME} 
    (id,email,firstName,lastName,user_password,user_signature,isEnterpriseAccount,accountVerified,hasTwoFactorAuth)
    VALUES (?,?,?,?,?,?,?,?,?)`

    return connection
      .query(sql, [
        user.getId().toString(),
        user.getEmail().toString(),
        user.getFirstName().toString(),
        user.getLastName().toString(),
        user.getPassword().toString(),
        user.getSignature().toString(),
        user.isEnterpriseAccount().getValue() ? '' : null,
        user.isAccountVerified() ? '' : null,
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
      new AccountVerified(user.accountVerified !== null),
      new TwoFactorAuth(user.hasTwoFactorAuth !== null)
    )
  }

  public async twoFactor(email: Email): Promise<TwoFactor> {
    const connection = await this.getConnection()
    const sql = `SELECT * FROM ${this.TABLE_NAME} WHERE email = ?`

    let user = await connection.query(sql, [email.toString()]).catch((err) => {
      throw new Error(err)
    })

    if (!Array.isArray(user) || user.length === 0) return null

    user = user[0]

    return new TwoFactor(
      new UserId(user.id),
      new TwoFactorKey(user.tfa_key),
      new EnterpriseAccount(user.isEnterpriseAccount !== null)
    )
  }
}

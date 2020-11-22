import { MySqlRepository } from './MySqlRepository'
import { IUserRepository } from '../../domain/IUserRepository'
import { User } from '../../domain/entity/User'
import { UserId } from '../../domain/value-object/UserId'
import { UserName } from '../../domain/value-object/UserName'

export class MySqlUserRepository
  extends MySqlRepository
  implements IUserRepository {
  private readonly TABLE_NAME = 'client'

  public async create(user: User): Promise<void> {
    const connection = await this.getConnection()
    const sql = `INSERT INTO ${this.TABLE_NAME} (id,client_name) VALUES (?,?)`

    return connection
      .query(sql, [user.getId().toString(), user.getName().toString()])
      .catch((err) => Promise.reject(err))
  }

  public async get(id: UserId): Promise<User | null> {
    const connection = await this.getConnection()
    const sql = `SELECT * FROM ${this.TABLE_NAME} WHERE id = ?`

    const users = await connection
      .query(sql, [id.toString()])
      .catch((err) => Promise.reject(err))

    if (!Array.isArray(users) || users.length === 0) return null

    const userName = users[0].client_name.split(' ')
    return new User(
      new UserName(userName[0], userName[1]),
      new UserId(users[0].id)
    )
  }

  public async update(user: User): Promise<boolean> {
    const connection = await this.getConnection()
    const sql = `UPDATE ${this.TABLE_NAME} SET client_name = ? WHERE id = ?`

    const response = await connection
      .query(sql, [user.getName().toString(), user.getId().toString()])
      .catch((err) => Promise.reject(err))

    const userUpdated = response.affectedRows !== 0
    return userUpdated
  }

  public async delete(id: UserId): Promise<boolean> {
    const connection = await this.getConnection()
    const sql = `DELETE FROM ${this.TABLE_NAME} WHERE id = ?`

    const response = await connection
      .query(sql, [id.toString()])
      .catch((err) => Promise.reject(err))

    const userDeleted = response.affectedRows !== 0
    return userDeleted
  }
}

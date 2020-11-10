import { User } from '../../domain/entity/User'
import { IUserRepository } from '../../domain/IUserRepository'
import { UserId } from '../../domain/value-object/UserId'
import { UserName } from '../../domain/value-object/UserName'
import { UserNotFoundError } from '../error/UserNotFoundError'
import { UserUpdaterRequest } from './UserUpdaterRequest'

export class UserUpdater {
  private repository: IUserRepository

  constructor(respository: IUserRepository) {
    this.repository = respository
  }

  async invoke(request: UserUpdaterRequest): Promise<User> {
    const user = new User(
      new UserName(request.firstName, request.lastName),
      new UserId(request.userId)
    )
    const updated = await this.repository.update(user)
    if (!updated)
      throw new UserNotFoundError(`with userId = ${request.userId.toString()}`)

    return user
  }
}

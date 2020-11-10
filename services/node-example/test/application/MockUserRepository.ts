import { User } from '../../src/domain/entity/User'
import { IUserRepository } from '../../src/domain/IUserRepository'
import { UserId } from '../../src/domain/value-object/UserId'

export class MockUserRepository implements IUserRepository {
  public update(user: User): Promise<boolean> {
    throw new Error('Method not implemented.')
  }

  public create(user: User): Promise<void> {
    throw new Error('Method not implemented.')
  }

  public get(id: UserId): Promise<User | null> {
    throw new Error('Method not implemented.')
  }

  public delete(id: UserId): Promise<boolean> {
    throw new Error('Method not implemented.')
  }
}

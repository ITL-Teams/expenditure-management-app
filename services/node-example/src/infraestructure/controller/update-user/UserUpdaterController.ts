import { Controller } from '../Controller'
import { UserUpdaterRequest } from './UserUpdaterRequest'
import { UserUpdaterResponse } from './UserUpdaterResponse'
import { UserUpdater } from '../../../application/update-user/UserUpdater'
import { IUserRepository } from '../../../domain/IUserRepository'

export class UserUpdaterController extends Controller<
  UserUpdaterRequest,
  UserUpdaterResponse
> {
  private service: UserUpdater

  constructor(repository: IUserRepository) {
    super()
    this.service = new UserUpdater(repository)
  }

  async handler(request: UserUpdaterRequest): Promise<UserUpdaterResponse> {
    try {
      this.validateRequest(request)

      const user = await this.service.invoke({
        firstName: request.firstName,
        lastName: request.lastName,
        userId: request.userId
      })

      return {
        success: {
          user: {
            id: user.getId().toString(),
            name: user.getName().toString()
          }
        }
      }
    } catch (error) {
      return {
        error: {
          message: 'User was not updated',
          reason: new String(error).toString()
        }
      }
    }
  }

  private validateRequest(request: UserUpdaterRequest): void {
    this.validateRequestParams([
      {
        value_name: 'firstName',
        value: request.firstName,
        expected: 'string'
      },
      {
        value_name: 'lastName',
        value: request.lastName,
        expected: 'string'
      },
      {
        value_name: 'userId',
        value: request.userId,
        expected: 'string'
      }
    ])
  }
}

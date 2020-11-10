import { Controller } from '../Controller'
import { UserCreatorRequest } from './UserCreatorRequest'
import { UserCreatorResponse } from './UserCreatorResponse'
import { UserCreator } from '../../../application/create-user/UserCreator'
import { IUserRepository } from '../../../domain/IUserRepository'

export class UserCreatorController extends Controller<
  UserCreatorRequest,
  UserCreatorResponse
> {
  private service: UserCreator

  constructor(repository: IUserRepository) {
    super()
    this.service = new UserCreator(repository)
  }

  async handler(request: UserCreatorRequest): Promise<UserCreatorResponse> {
    try {
      this.validateRequest(request)

      const user = await this.service.invoke({
        firstName: request.firstName,
        lastName: request.lastName
      })

      return {
        success: {
          message: `User: ${request.firstName} ${request.lastName} has been registered in db`,
          id: user.getId().toString()
        }
      }
    } catch (error) {
      return {
        error: {
          message: 'User was not registered',
          reason: new String(error).toString()
        }
      }
    }
  }

  private validateRequest(request: UserCreatorRequest): void {
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
      }
    ])
  }
}

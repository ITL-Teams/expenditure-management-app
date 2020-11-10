import { Controller } from '../Controller'
import { UserDeleterRequest } from './UserDeleterRequest'
import { UserDeleterResponse } from './UserDeleterResponse'
import { UserDeleter } from '../../../application/delete-user/UserDeleter'
import { IUserRepository } from '../../../domain/IUserRepository'

export class UserDeleterController extends Controller<
  UserDeleterRequest,
  UserDeleterResponse
> {
  private service: UserDeleter

  constructor(repository: IUserRepository) {
    super()
    this.service = new UserDeleter(repository)
  }

  async handler(request: UserDeleterRequest): Promise<UserDeleterResponse> {
    try {
      this.validateRequest(request)

      await this.service.invoke({
        userId: request.userId
      })

      return {
        success: {
          message: `User with id = ${request.userId} was successfully removed`
        }
      }
    } catch (error) {
      return {
        error: {
          message: 'User was not deleted',
          reason: new String(error).toString()
        }
      }
    }
  }

  private validateRequest(request: UserDeleterRequest): void {
    this.validateRequestParams([
      {
        value_name: 'userId',
        value: request.userId,
        expected: 'string'
      }
    ])
  }
}

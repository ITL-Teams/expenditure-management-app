import { Controller } from '../Controller'
import { UserFinderRequest } from './UserFinderRequest'
import { UserFinderResponse } from './UserFinderResponse'
import { IUserRepository } from '../../../domain/IUserRepository'
import { UserFinder } from '../../../application/get-user/UserFinder'

export class UserFinderController extends Controller<
  UserFinderRequest,
  UserFinderResponse
> {
  private service: UserFinder

  constructor(repository: IUserRepository) {
    super()
    this.service = new UserFinder(repository)
  }

  async handler(request: UserFinderRequest): Promise<UserFinderResponse> {
    try {
      this.validateRequest(request)

      const user = await this.service.invoke({
        user_id: request.userId
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
          message: 'User not found',
          reason: new String(error).toString()
        }
      }
    }
  }

  private validateRequest(request: UserFinderRequest): void {
    this.validateRequestParams([
      {
        value_name: 'userId',
        value: request.userId,
        expected: 'string'
      }
    ])
  }
}

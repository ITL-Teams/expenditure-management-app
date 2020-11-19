import { Controller } from '../Controller'
import { UserRegisterControllerRequest } from './UserRegisterControllerRequest'
import { UserRegisterControllerResponse } from './UserRegisterControllerResponse'
import { UserRegister } from '../../../application/user-register/UserRegister'
import { ICredentialsRepository } from '../../../domain/ICredentialsRepository'

export class UserRegisterController extends Controller<
  UserRegisterControllerRequest,
  UserRegisterControllerResponse
> {
  private service: UserRegister

  constructor(repository: ICredentialsRepository) {
    super()
    this.service = new UserRegister(repository)
  }

  async handler(
    request: UserRegisterControllerRequest
  ): Promise<UserRegisterControllerResponse> {
    try {
      this.validateRequest(request)

      const user = await this.service.invoke({
        email: request.email,
        firstName: request.firstName,
        lastName: request.lastName,
        password: request.password,
        signature: request.signature,
        isEnterpriseAccount: request.enterprise_account
      })

      return {
        success: {
          message: user.message,
          user_id: user.user_id
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

  private validateRequest(request: UserRegisterControllerRequest): void {
    this.validateRequestParams([
      {
        value_name: 'email',
        value: request.email,
        expected: 'string'
      },
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
        value_name: 'password',
        value: request.password,
        expected: 'string'
      },
      {
        value_name: 'signature',
        value: request.signature,
        expected: 'string'
      },
      {
        value_name: 'enterprise_account',
        value: request.enterprise_account,
        expected: 'boolean'
      }
    ])
  }
}

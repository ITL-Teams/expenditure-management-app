import { RegisterUser } from '../../domain/entity/RegisterUser'
import { ICredentialsRepository } from '../../domain/ICredentialsRepository'
import { Email } from '../../domain/value-object/Email'
import { EnterpriseAccount } from '../../domain/value-object/EnterpriseAccount'
import { FirstName } from '../../domain/value-object/FirstName'
import { LastName } from '../../domain/value-object/LastName'
import { Password } from '../../domain/value-object/Password'
import { Signature } from '../../domain/value-object/Signature'
import { UserId } from '../../domain/value-object/UserId'
import { UserRegisterRequest } from './UserRegisterRequest'
import { UserRegisterResponse } from './UserRegisterResponse'

export class UserRegister {
  private repository: ICredentialsRepository

  constructor(respository: ICredentialsRepository) {
    this.repository = respository
  }

  async invoke(request: UserRegisterRequest): Promise<UserRegisterResponse> {
    const userId = new UserId()

    await this.repository.create(
      new RegisterUser(
        userId,
        new Email(request.email),
        new FirstName(request.firstName),
        new LastName(request.lastName),
        new Password(request.password, true),
        new Signature(request.signature),
        new EnterpriseAccount(request.isEnterpriseAccount)
      )
    )

    return {
      user_id: userId.toString(),
      message: `User was registered successfully`
    }
  }
}

import { ICredentialsRepository } from '../../domain/ICredentialsRepository'
import { Email } from '../../domain/value-object/Email'
import { Password } from '../../domain/value-object/Password'
import { CredentialsValidatorRequest } from './CredentialsValidatorRequest'
import { CredentialsValidatorResponse } from './CredentialsValidatorResponse'

export class CredentialsValidator {
  private repository: ICredentialsRepository

  constructor(respository: ICredentialsRepository) {
    this.repository = respository
  }

  async invoke(
    request: CredentialsValidatorRequest
  ): Promise<CredentialsValidatorResponse> {
    const password = new Password(request.password, false)
    const loginUser = await this.repository.find(new Email(request.email))

    if (loginUser === null) return { status: 'NOT_AUTHORIZED' }
    if (!loginUser.getPassword().match(password))
      return { status: 'NOT_AUTHORIZED' }

    return {
      status: loginUser.hasTwoFactorAuth().getValue()
        ? '2FA_REQUIRED'
        : 'VALID_CREDENTIALS',
      user_data: {
        enterprise_account: loginUser.isEnterpriseAccount().getValue(),
        user_id: loginUser.getId().toString()
      }
    }
  }
}

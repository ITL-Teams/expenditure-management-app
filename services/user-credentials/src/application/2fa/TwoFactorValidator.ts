import { ICredentialsRepository } from '../../domain/ICredentialsRepository'
import { Email } from '../../domain/value-object/Email'
import { TwoFactorCode } from '../../domain/value-object/TwoFactorCode'
import { TwoFactorValidatorRequest } from './TwoFactorValidatorRequest'
import { TwoFactorValidatorResponse } from './TwoFactorValidatorResponse'

export class TwoFactorValidator {
  private repository: ICredentialsRepository

  constructor(respository: ICredentialsRepository) {
    this.repository = respository
  }

  async invoke(
    request: TwoFactorValidatorRequest
  ): Promise<TwoFactorValidatorResponse> {
    const twoFactor = await this.repository.twoFactor(new Email(request.email))

    if (twoFactor === null) return { status: 'FAILED' }

    if (!twoFactor.getKey().match(new TwoFactorCode(request.code)))
      return { status: 'FAILED' }

    return {
      status: 'OK',
      user_data: {
        user_id: twoFactor.getId().toString(),
        enterprise_account: twoFactor.isEnterpriseAccount().getValue()
      }
    }
  }
}

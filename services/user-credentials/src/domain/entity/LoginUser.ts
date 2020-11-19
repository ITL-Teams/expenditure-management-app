import { EnterpriseAccount } from '../value-object/EnterpriseAccount'
import { UserId } from '../value-object/UserId'
import { TwoFactorAuth } from '../value-object/TwoFactorAuth'
import { Password } from '../value-object/Password'

export class LoginUser {
  private readonly userId: UserId
  private readonly password: Password
  private readonly _isEnterpriseAccount: EnterpriseAccount
  private readonly has2fa: TwoFactorAuth

  constructor(
    userId: UserId,
    password: Password,
    isEnterpriseAccount: EnterpriseAccount,
    has2Fa: TwoFactorAuth
  ) {
    this.userId = userId
    this.password = password
    this._isEnterpriseAccount = isEnterpriseAccount
    this.has2fa = has2Fa
  }

  public getId(): UserId {
    return this.userId
  }

  public getPassword(): Password {
    return this.password
  }

  public isEnterpriseAccount(): EnterpriseAccount {
    return this._isEnterpriseAccount
  }

  public hasTwoFactorAuth(): TwoFactorAuth {
    return this.has2fa
  }
}

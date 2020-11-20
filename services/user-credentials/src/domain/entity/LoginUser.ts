import { EnterpriseAccount } from '../value-object/EnterpriseAccount'
import { UserId } from '../value-object/UserId'
import { TwoFactorAuth } from '../value-object/TwoFactorAuth'
import { Password } from '../value-object/Password'
import { AccountVerified } from '../value-object/AccountVerified'

export class LoginUser {
  private readonly userId: UserId
  private readonly password: Password
  private readonly _isEnterpriseAccount: EnterpriseAccount
  private readonly _isAccountVerified: AccountVerified
  private readonly has2fa: TwoFactorAuth

  constructor(
    userId: UserId,
    password: Password,
    isEnterpriseAccount: EnterpriseAccount,
    isAccountVerified: AccountVerified,
    has2Fa: TwoFactorAuth
  ) {
    this.userId = userId
    this.password = password
    this._isEnterpriseAccount = isEnterpriseAccount
    this._isAccountVerified = isAccountVerified
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

  public isAccountVerified(): EnterpriseAccount {
    return this._isAccountVerified
  }

  public hasTwoFactorAuth(): TwoFactorAuth {
    return this.has2fa
  }
}

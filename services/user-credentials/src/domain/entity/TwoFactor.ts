import { EnterpriseAccount } from '../value-object/EnterpriseAccount'
import { UserId } from '../value-object/UserId'
import { TwoFactorKey } from '../value-object/TwoFactorKey'

export class TwoFactor {
  private readonly userId: UserId
  private readonly key: TwoFactorKey
  private readonly _isEnterpriseAccount: EnterpriseAccount

  constructor(
    userId: UserId,
    key: TwoFactorKey,
    isEnterpriseAccount: EnterpriseAccount
  ) {
    this.userId = userId
    this.key = key
    this._isEnterpriseAccount = isEnterpriseAccount
  }

  public getId(): UserId {
    return this.userId
  }

  public getKey(): TwoFactorKey {
    return this.key
  }

  public isEnterpriseAccount(): EnterpriseAccount {
    return this._isEnterpriseAccount
  }
}

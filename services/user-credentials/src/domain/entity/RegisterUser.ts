import { UserId } from '../value-object/UserId'
import { FirstName } from '../value-object/FirstName'
import { LastName } from '../value-object/LastName'
import { Password } from '../value-object/Password'
import { Signature } from '../value-object/Signature'
import { EnterpriseAccount } from '../value-object/EnterpriseAccount'
import { Email } from '../value-object/Email'

export class RegisterUser {
  private readonly userId: UserId
  private readonly email: Email
  private readonly firstName: FirstName
  private readonly lastName: LastName
  private readonly password: Password
  private readonly signature: Signature
  private readonly _isEnterpriseAccount: EnterpriseAccount

  constructor(
    userId: UserId,
    email: Email,
    firstName: FirstName,
    lastName: LastName,
    password: Password,
    signature: Signature,
    isEnterpriseAccount: EnterpriseAccount
  ) {
    this.userId = userId
    this.email = email
    this.firstName = firstName
    this.lastName = lastName
    this.password = password
    this.signature = signature
    this._isEnterpriseAccount = isEnterpriseAccount
  }

  public getId(): UserId {
    return this.userId
  }

  public getEmail(): Email {
    return this.email
  }

  public getFirstName(): FirstName {
    return this.firstName
  }

  public getLastName(): FirstName {
    return this.lastName
  }

  public getPassword(): Password {
    return this.password
  }

  public getSignature(): FirstName {
    return this.signature
  }

  public isEnterpriseAccount(): EnterpriseAccount {
    return this._isEnterpriseAccount
  }

  public isAccountVerified(): boolean {
    return !this._isEnterpriseAccount.getValue()
  }
}

import { AccountId } from '../value-object/AccountId'
import { BudgetId } from '../value-object/BudgetId'
import { AgreementId } from '../value-object/AgreementId'
import { ClientName } from '../value-object/ClientName'
import { AgreementMessage } from '../value-object/AgreementMessage'
import { AgreementSignature } from '../value-object/AgreementSignature'

export class Agreement {
  private readonly accountId: AccountId
  private readonly budgetId: BudgetId
  private readonly agreementId: AgreementId
  private readonly clientName: ClientName
  private readonly agreementMessage: AgreementMessage
  private readonly agreementSignature: AgreementSignature

  constructor(
    accountId: AccountId,
    budgetId: BudgetId,
    clientName: ClientName,
    agreementMessage?: AgreementMessage,
    agreementId?: AgreementId,
    agreementSignature?: AgreementSignature
  ) {
    this.agreementId = agreementId || new AgreementId(this.generateId())
    this.accountId = accountId
    this.budgetId = budgetId
    this.clientName = clientName
    this.agreementMessage = agreementMessage
    this.agreementSignature =
      agreementSignature ||
      new AgreementSignature(this.functionSignatureAgreement())
  }

  private generateId(): string {
    const random: number = Math.floor(Math.random() * 100)
    return new Date().getTime().toString().concat(random.toString())
  }

  private noMessage(): string {
    return "This agreement between [Company name] and [Contact name]  is hereby entered into on this date: [Date here]. Purpose: [Company name] and [Contact name] will be entering into discussions involving [Company name]'s development and operation, which require [Company name] to disclose confidential information to [Contact name] on an ongoing basis. This agreement's purpose is to ensure confidentiality and to prevent [Contact name] from disclosing such confidential information"
  }

  private functionSignatureAgreement(): string {
    let signatureAgreement = ''
    const characters =
      'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'
    const charactersLength = characters.length
    for (let i = 0; i < charactersLength; i++) {
      signatureAgreement += characters.charAt(
        Math.floor(Math.random() * charactersLength)
      )
    }

    return signatureAgreement
  }

  public getAccountId(): AccountId {
    return this.accountId
  }

  public getBudgetId(): BudgetId {
    return this.budgetId
  }

  public getAgreementId(): AgreementId {
    return this.agreementId
  }

  public getClientName(): ClientName {
    return this.clientName
  }

  public getAgreementMessage(): AgreementMessage {
    return this.agreementMessage.toString() == 'undefined'
      ? new AgreementMessage(this.noMessage())
      : this.agreementMessage
  }

  public getAgreementSignature(): AgreementSignature {
    return this.agreementSignature
  }
}

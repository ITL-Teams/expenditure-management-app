import { AccountId } from '../value-object/AccountId'
import { AgreementId } from '../value-object/AgreementId'
import { AgreementMessage } from '../value-object/AgreementMessage'
import { AgreementSignature } from '../value-object/AgreementSignature'
import { BudgetId } from '../value-object/BudgetId'
import { ClientName } from '../value-object/ClientName'

export class AgreementFinderEntity {
  private readonly agreementId: AgreementId
  private readonly agreementMessage: AgreementMessage
  private readonly agreementSignature: AgreementSignature
  private readonly accountId: AccountId
  private readonly budgetId: BudgetId
  private readonly clientName: ClientName

  constructor(
    agreementId: AgreementId,
    agreementMessage: AgreementMessage,
    agreementSignature: AgreementSignature,
    accountId: AccountId,
    budgetId: BudgetId,
    clientName: ClientName
  ) {
    this.agreementId = agreementId
    this.agreementMessage = agreementMessage
    this.agreementSignature = agreementSignature
    this.accountId = accountId
    this.budgetId = budgetId
    this.clientName = clientName
  }

  public getAgreementId(): AgreementId {
    return this.agreementId
  }

  public getAgreementMessage(): AgreementMessage {
    return this.agreementMessage
  }

  public getAgreementSignature(): AgreementSignature {
    return this.agreementSignature
  }

  public getAccountId(): AccountId {
    return this.accountId
  }

  public getBudgetId(): BudgetId {
    return this.budgetId
  }

  public getClientName(): ClientName {
    return this.clientName
  }
}

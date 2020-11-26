import { Agreement } from '../../domain/entity/Agreement'
import { IAgreementRepository } from '../../domain/IAgreementRepository'
import { AccountId } from '../../domain/value-object/AccountId'
import { BudgetId } from '../../domain/value-object/BudgetId'
import { ClientName } from '../../domain/value-object/ClientName'
import { AgreementMessage } from '../../domain/value-object/AgreementMessage'
import { AgreementCreatorRequest } from './AgreementCreatorRequest'
import { AgreementId } from '../../domain/value-object/AgreementId'

export class AgreementCreator {
  private repository: IAgreementRepository

  constructor(respository: IAgreementRepository) {
    this.repository = respository
  }

  async invoke(request: AgreementCreatorRequest): Promise<Agreement> {
    const agreement = new Agreement(
      new AccountId(request.account_id),
      new BudgetId(request.budget_id),
      new ClientName(request.client_name),
      new AgreementMessage(request.agreement_message)
    )
    await this.repository.create(agreement)
    return agreement
  }
}

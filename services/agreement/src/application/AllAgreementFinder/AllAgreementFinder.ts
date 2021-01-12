import { IAgreementRepository } from '../../domain/IAgreementRepository'
import { AllAgreementFinderRequest } from './AllAgreementFinderRequest'
import {
  AllAgreementFinderReponse,
  AgreementRepose
} from './AllAgreementFinderReponse'
import { AccountId } from '../../domain/value-object/AccountId'
import { AccountNotFound } from '../error/AccountNotFound'

export class AllAgreementFinder {
  private repository: IAgreementRepository

  constructor(respository: IAgreementRepository) {
    this.repository = respository
  }

  async invoke(
    request: AllAgreementFinderRequest
  ): Promise<AllAgreementFinderReponse> {
    const accountId = new AccountId(request.accountId)
    const userExists = await this.repository.userExists(accountId)

    if (!userExists)
      throw new AccountNotFound(
        `account_id = ${request.accountId} does not exist`
      )

    const agreements = await this.repository.findAll(accountId)

    let agreementsResponse: AgreementRepose[] = []

    for (const agreement of agreements) {
      agreementsResponse.push({
        accountId: agreement.getAccountId().toString(),
        budgetId: agreement.getBudgetId().toString(),
        agreementId: agreement.getAgreementId().toString(),
        agreementMessage: agreement.getAgreementMessage().toString(),
        agreementSignature: agreement.getAgreementSignature().toString(),
        clientName: agreement.getClientName().toString()
      })
    }

    return {
      accountId: request.accountId,
      agreements: agreementsResponse
    }
  }
}

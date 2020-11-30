import { AgreementNotFoundError } from '../error/AgreementNotFoundError'
import { IAgreementRepository } from '../../domain/IAgreementRepository'
import { AgreementId } from '../../domain/value-object/AgreementId'
import { AgreementFinderRequest } from './AgreementFinderRequest'
import { AgreementFinderResponse } from './AgreementFinderReponse'

export class AgreementFinder {
  private repository: IAgreementRepository

  constructor(respository: IAgreementRepository) {
    this.repository = respository
  }

  async invoke(
    request: AgreementFinderRequest
  ): Promise<AgreementFinderResponse> {
    const agreement = await this.repository.find(
      new AgreementId(request.agreementId)
    )
    if (!agreement)
      throw new AgreementNotFoundError(
        `Agreement with id = ${request.agreementId} does not exist in database`
      )

    return {
      agreementId: agreement.getAgreementId().toString(),
      agreementMessage: agreement.getAgreementMessage().toString(),
      agreementSignature: agreement.getAgreementSignature().toString(),
      account_id: agreement.getAccountId().toString(),
      budget_id: agreement.getBudgetId().toString(),
      client_name: agreement.getClientName().toString()
    }
  }
}

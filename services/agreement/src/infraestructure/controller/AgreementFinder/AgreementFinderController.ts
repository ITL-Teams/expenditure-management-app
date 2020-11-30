import { Controller } from '../Controller'
import { AgreementFinderControllerRequest } from './AgreementFinderControllerRequest'
import { AgreementFinderControllerResponse } from './AgreementFinderControllerResponse'
import { AgreementFinder } from '../../../application/AgreementFinder/AgreementFinder'
import { IAgreementRepository } from '../../../domain/IAgreementRepository'

export class AgreementFinderController extends Controller<
  AgreementFinderControllerRequest,
  AgreementFinderControllerResponse
> {
  private service: AgreementFinder

  constructor(repository: IAgreementRepository) {
    super()
    this.service = new AgreementFinder(repository)
  }

  async handler(
    request: AgreementFinderControllerRequest
  ): Promise<AgreementFinderControllerResponse> {
    try {
      const agreement = await this.service.invoke({
        agreementId: request.agreementId
      })

      return {
        success: {
          agreement_id: agreement.agreementId,
          agreement_message: agreement.agreementMessage,
          agreement_signature: agreement.agreementSignature,
          account_id: agreement.account_id,
          budget_id: agreement.budget_id,
          client_name: agreement.client_name
        }
      }
    } catch (error) {
      return {
        error: {
          message: 'Agreement not found',
          reason: new String(error).toString()
        }
      }
    }
  }
}

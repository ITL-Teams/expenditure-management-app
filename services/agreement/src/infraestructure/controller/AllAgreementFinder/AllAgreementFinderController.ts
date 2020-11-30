import { Controller } from '../Controller'
import { AllAgreementFinderControllerRequest } from './AllAgreementFinderControllerRequest'
import { AllAgreementFinderControllerResponse } from './AllAgreementFinderControllerResponse'
import { AllAgreementFinder } from '../../../application/AllAgreementFinder/AllAgreementFinder'
import { IAgreementRepository } from '../../../domain/IAgreementRepository'

export class AllAgreementFinderController extends Controller<
  AllAgreementFinderControllerRequest,
  AllAgreementFinderControllerResponse
> {
  private service: AllAgreementFinder

  constructor(repository: IAgreementRepository) {
    super()
    this.service = new AllAgreementFinder(repository)
  }

  async handler(
    request: AllAgreementFinderControllerRequest
  ): Promise<AllAgreementFinderControllerResponse> {
    try {
      const agreements = await this.service.invoke({
        accountId: request.accountId
      })

      return {
        success: {
          account_id: agreements.accountId,
          agreements: agreements.agreements
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

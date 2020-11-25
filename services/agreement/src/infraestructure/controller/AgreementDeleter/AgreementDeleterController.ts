import { Controller } from '../Controller'
import { AgreementDeleterRequest } from './AgreementDeleterRequest'
import { AgreementDeleterResponse } from './AgreementDeleterResponse'
import { AgreementDeleter } from '../../../application/AgreementDeleter/AgreementDeleter'
import { IAgreementRepository } from '../../../domain/IAgreementRepository'

export class AgreementDeleterController extends Controller<
  AgreementDeleterRequest,
  AgreementDeleterResponse
> {
  private service: AgreementDeleter

  constructor(repository: IAgreementRepository) {
    super()
    this.service = new AgreementDeleter(repository)
  }

  async handler(request: AgreementDeleterRequest): Promise<AgreementDeleterResponse> {
    try {
      this.validateRequest(request)

      await this.service.invoke({
        agreementId: request.agreementId
      })

      return {
        success: {
          message: `true`
        }
      }
    } catch (error) {
      return {
        error: {
          message: 'Agreement was not deleted',
          reason: new String(error).toString()
        }
      }
    }
  }

  private validateRequest(request: AgreementDeleterRequest): void {
    this.validateRequestParams([
      {
        value_name: 'agreementId',
        value: request.agreementId,
        expected: 'string'
      }
    ])
  }
}

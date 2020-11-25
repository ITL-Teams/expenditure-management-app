import { Controller } from '../Controller'
import { AgreementCreatorRequest } from './AgreementCreatorRequest'
import { AgreementCreatorResponse } from './AgreementCreatorResponse'
import { AgreementCreator } from '../../../application/AgreementCreator/AgreementCreator'
import { IAgreementRepository } from '../../../domain/IAgreementRepository'
import { Agreement } from '../../../domain/entity/Agreement'

export class AgreementCreatorController extends Controller<
  AgreementCreatorRequest,
  AgreementCreatorResponse
> {
  private service: AgreementCreator

  constructor(repository: IAgreementRepository) {
    super()
    this.service = new AgreementCreator(repository)
  }

  async handler(
    request: AgreementCreatorRequest
  ): Promise<AgreementCreatorResponse> {
    try {
      this.validateRequest(request)

      const AgreementCreator = await this.service.invoke({
        account_id: request.account_id,
        budget_id: request.budget_id,
        client_name: request.client_name,
        agreement_message: request.agreement_message
      })

      return {
        success: {
          agreement_id: AgreementCreator.getAgreementId().toString(),
          agreement_message: request.agreement_message,
          agreement_signature: AgreementCreator.getAgreementSignature().toString()
        }
      }
    } catch (error) {
      return {
        error: {
          message: 'Agreement was not registered',
          reason: new String(error).toString()
        }
      }
    }
  }

  private validateRequest(request: AgreementCreatorRequest): void {
    this.validateRequestParams([
      {
        value_name: 'account_id',
        value: request.account_id,
        expected: 'string'
      },
      {
        value_name: 'budget_id',
        value: request.budget_id,
        expected: 'string'
      },
      {
        value_name: 'client_name',
        value: request.client_name,
        expected: 'string'
      },
      {
        value_name: 'agreement_message',
        value: request.agreement_message,
        expected: 'string'
      }
    ])
  }
}

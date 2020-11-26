import { AgreementNotFoundError } from '../error/AgreementNotFoundError'
import { IAgreementRepository } from '../../domain/IAgreementRepository'
import { AgreementId } from '../../domain/value-object/AgreementId'
import { AgreementDeleterRequest } from './AgreementDeleterRequest'

export class AgreementDeleter {
  private repository: IAgreementRepository

  constructor(respository: IAgreementRepository) {
    this.repository = respository
  }

  async invoke(request: AgreementDeleterRequest): Promise<void> {
    const deleted = await this.repository.delete(new AgreementId(request.agreementId))
    if (!deleted)
      throw new AgreementNotFoundError(
        `Agreement with id = ${request.agreementId} does not exist in database`
      )
  }
}

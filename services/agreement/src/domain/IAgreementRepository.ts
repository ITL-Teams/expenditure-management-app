import { Agreement } from './entity/Agreement'
import { AgreementFinderEntity } from './entity/AgreementFinderEntity'
import { AgreementId } from './value-object/AgreementId'

export interface IAgreementRepository {
  create(agreement: Agreement): Promise<void>
  delete(agreementId: AgreementId): Promise<boolean>
  find(agreementId: AgreementId): Promise<AgreementFinderEntity | null>
}

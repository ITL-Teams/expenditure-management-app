import { Agreement } from './entity/Agreement'
import { AgreementId } from './value-object/AgreementId'

export interface IAgreementRepository {
  create(agreement: Agreement): Promise<void>
}

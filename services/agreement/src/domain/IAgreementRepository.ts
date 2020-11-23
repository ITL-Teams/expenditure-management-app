import { AgreementId } from './value-object/AgreementId'

export interface IAgreementRepository {
  delete(agreementId: AgreementId): Promise<boolean>
}

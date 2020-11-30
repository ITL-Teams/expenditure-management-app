import { Agreement } from './entity/Agreement'
import { AgreementFinderEntity } from './entity/AgreementFinderEntity'
import { AccountId } from './value-object/AccountId'
import { AgreementId } from './value-object/AgreementId'

export interface IAgreementRepository {
  create(agreement: Agreement): Promise<void>
  delete(agreementId: AgreementId): Promise<boolean>
  find(agreementId: AgreementId): Promise<AgreementFinderEntity | null>
  userExists(accountId: AccountId): Promise<boolean>
  findAll(accountId: AccountId): Promise<AgreementFinderEntity[] | null>
}

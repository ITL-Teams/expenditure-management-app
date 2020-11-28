import { MySqlRepository } from './MySqlRepository'
import { IAgreementRepository } from '../../domain/IAgreementRepository'
import { Agreement } from '../../domain/entity/Agreement'
import { AgreementId } from '../../domain/value-object/AgreementId'
import { AccountIdNotExists } from './error/AccountIdNotExist'
import { AgreementFinderEntity } from '../../domain/entity/AgreementFinderEntity'
import { AgreementMessage } from '../../domain/value-object/AgreementMessage'
import { AgreementSignature } from '../../domain/value-object/AgreementSignature'
import { AccountId } from '../../domain/value-object/AccountId'
import { BudgetId } from '../../domain/value-object/BudgetId'
import { ClientName } from '../../domain/value-object/ClientName'

export class MySqlAgreementRepository
  extends MySqlRepository
  implements IAgreementRepository {
  private readonly TABLE_NAME = 'agreement'
  private readonly TABLE_NAME_USER = 'user_credentials'

  public async create(agreement: Agreement): Promise<void> {
    const connection = await this.getConnection()
    const sql = `INSERT INTO ${this.TABLE_NAME}
                    (
                        id,
                        account_id,
                        budget_id,
                        client_name,
                        agreement_message,
                        agreement_signature
                    ) SELECT ?,?,?,?,?,?
                    WHERE EXISTS ( SELECT id FROM ${this.TABLE_NAME_USER}
                        WHERE id = \'${agreement.getAccountId().toString()}\' )`

    const response = await connection
      .query(sql, [
        agreement.getAgreementId().toString(),
        agreement.getAccountId().toString(),
        agreement.getBudgetId().toString(),
        agreement.getClientName().toString(),
        agreement.getAgreementMessage().toString(),
        agreement.getAgreementSignature().toString()
      ])
      .catch((err) => Promise.reject(err))
    if (response.affectedRows > 0) return connection
    else throw new AccountIdNotExists(agreement.getAccountId().toString())
  }

  public async delete(id: AgreementId): Promise<boolean> {
    const connection = await this.getConnection()
    const sql = `DELETE FROM ${this.TABLE_NAME} WHERE id = ?`

    const response = await connection
      .query(sql, [id.toString()])
      .catch((err) => Promise.reject(err))

    const agreementDeleted = response.affectedRows !== 0
    return agreementDeleted
  }

  public async find(agreementId: AgreementId): Promise<AgreementFinderEntity> {
    const connection = await this.getConnection()
    const sql = `SELECT * FROM ${this.TABLE_NAME} WHERE id = ?`

    let agreement = await connection
      .query(sql, [agreementId.toString()])
      .catch((err) => {
        throw new Error(err)
      })

    if (!Array.isArray(agreement) || agreement.length === 0) return null

    agreement = agreement[0]

    return new AgreementFinderEntity(
      new AgreementId(agreement.id),
      new AgreementMessage(agreement.agreement_message),
      new AgreementSignature(agreement.agreement_signature),
      new AccountId(agreement.account_id),
      new BudgetId(agreement.budget_id),
      new ClientName(agreement.client_name)
    )
  }
}

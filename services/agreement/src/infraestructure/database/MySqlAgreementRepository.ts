import { MySqlRepository } from './MySqlRepository'
import { IAgreementRepository } from '../../domain/IAgreementRepository'
import { Agreement } from '../../domain/entity/Agreement'

export class MySqlAgreementRepository
  extends MySqlRepository
  implements IAgreementRepository {
  private readonly TABLE_NAME = 'agreement'

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
                    ) VALUES (?,?,?,?,?,?)`

    return connection
      .query(sql, [
        agreement.getAgreementId().toString(),
        agreement.getAccountId().toString(),
        agreement.getBudgetId().toString(),
        agreement.getClientName().toString(),
        agreement.getAgreementMessage().toString(),
        'signature'
      ])
      .catch((err) => Promise.reject(err))
  }
}
